<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Shift;
use App\Models\Guard;
use App\Models\User;
use App\Models\Pleton;
use App\Models\Wilayah;
use App\Models\Area;
use App\Models\PivotGuardProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class GuardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->user()->hasRole('super-admin'));
        $data['title'] = "Daftar Petugas";
        return view('super-admin.guard-page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Tambah Guard';
        $data['area'] = Area::all();
        $data['shifts'] = Shift::all();
        $data['wilayah'] = Wilayah::all();

        // Dapatkan daftar ID pleton yang sudah dipilih
        // $selectedPletonIds = Guard::pluck('pleton_id')->toArray();
        // $data['pletons'] = Pleton::whereNotIn('id', $selectedPletonIds)->get();
        $data['pletons'] = Pleton::all();

        return view('super-admin.guard-page.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'badge_number' => 'required|string|max:255|unique:guards',
                'name' => 'required|string|max:255',
                'img_avatar' => 'image|mimes:jpeg,png,jpg',
                'dob' => 'required|date',
                'gender' => 'required|in:MALE,FEMALE',
                'email' => 'required|email|unique:guards',
                'wa' => 'required|string|unique:guards',
                'address' => 'required|string|max:255',
                'shift_id' => 'required|numeric|exists:shift,id',
                'pleton_id' => 'required|numeric|exists:pleton,id',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            // Menangani upload avatar
            $imgAvatar = null;
            if ($request->hasFile('img_avatar')) {
                $file = $request->file('img_avatar');

                $fileName = $file->getClientOriginalName();
                $fileContent = file_get_contents($file->getRealPath());
                $response = upload_image_api($fileContent, $fileName);

                $result = json_decode($response, true);
                $imgAvatar = $result['message'];
            }

            $validatedData = $validator->validated();

            // Create a new Guard instance with validated data
            $guard = new Guard([
                'badge_number' => $validatedData['badge_number'],
                'name' => $validatedData['name'],
                'img_avatar' => $imgAvatar,
                'dob' => $validatedData['dob'],
                'gender' => $validatedData['gender'],
                'email' => $validatedData['email'],
                'wa' => $validatedData['wa'],
                'address' => $validatedData['address'],
                'shift_id' => $validatedData['shift_id'],
                'pleton_id' => $validatedData['pleton_id'],
                'created_at' => now(),
                'updated_at' => null,
            ]);

            $guard->save();
            $guardId = $guard->id;
            DB::commit();

            insert_audit_log('Insert data guard');
            return $this->store_user($validatedData, $guardId);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('GuardController store() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Guard gagal disimpan: ' . $e->getMessage());
        }
    }


    public function store_user($data, $guardId)
    {
        try {
            DB::beginTransaction();

            $data_user = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'status' => 'ACTIVED',
                'guard_id' => $guardId,
                'no_badge' => $data['badge_number'],
                'created_at' => now(),
                'updated_at' => null,
            ];

            $user = User::create($data_user);
            $user->assignRole('user');
            DB::commit();

            insert_audit_log('Automated insert data user after data guard was created');
            return redirect()->route('guard.index')->with('success', 'User guard berhasil ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('GuardController store() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'User guard gagal ditambahkan: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guard  $guard
     * @return \Illuminate\Http\Response
     */
    public function show(Guard $guard)
    {
        $title = 'Detail Guard';
        // Eager load any additional relationships needed for the view
        $guard->load('pleton', 'shift');

        // Mengirim data Guard dan title ke view sebagai variabel terpisah
        return view('super-admin.guard-page.show', compact('guard', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guard  $guard
     * @return \Illuminate\Http\Response
     */
    public function edit(Guard $guard)
    {
        $data['title'] = 'Edit Guard';
        $data['guard'] = $guard;
        $data['shifts'] = Shift::all();
        $selectedPletonIds = Guard::pluck('pleton_id')->toArray();
        $pletonNotSelected = Pleton::whereNotIn('id', $selectedPletonIds)->get();
        $pletonSelected = Pleton::where('id', $guard->pleton_id)->get();

        $data['pletons'] = $pletonNotSelected->merge($pletonSelected);

        return view('super-admin.guard-page.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guard  $guard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guard $guard)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'badge_number' => 'required|string|max:255|unique:guards,badge_number,' . $guard->id,
                'name' => 'required|string|max:255',
                'img_avatar' => 'image|mimes:jpeg,png,jpg',
                'dob' => 'required|date',
                'gender' => 'required|in:MALE,FEMALE',
                'email' => 'required|email|unique:guards,email,' . $guard->id,
                'wa' => 'required|string|unique:guards,wa,' . $guard->id,
                'address' => 'required|string|max:255',
                'shift_id' => 'required|numeric|exists:shift,id',
                'pleton_id' => 'required|numeric|exists:pleton,id',
                'password' => 'nullable|string',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $validated = $validator->validated();

            // Perbarui password jika disediakan
            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            // Menangani upload thumbnail patrol area
            $imgAvatar = $guard->img_avatar;
            if ($request->hasFile('img_avatar')) {
                $file = $request->file('img_avatar');

                $fileName = $file->getClientOriginalName();
                $fileContent = file_get_contents($file->getRealPath());
                $response = upload_image_api($fileContent, $fileName);

                $result = json_decode($response, true);
                $imgAvatar = $result['message'];
            }

            $update = [
                'badge_number' => $validated['badge_number'],
                'name' => $validated['name'],
                'img_avatar' => $imgAvatar,
                'dob' => $validated['dob'],
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'wa' => $validated['wa'],
                'address' => $validated['address'],
                'shift_id' => $validated['shift_id'],
                'pleton_id' => $validated['pleton_id'],
                'created_at' => $guard->created_at,
                'updated_at' => now(),
            ];

            $guard->update($update);
            DB::commit();

            insert_audit_log('Update data guard');
            redis_reset_api('guard/spesific/'.$guard->id);
            return $this->update_user($validated, $guard->id);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('GuardController update() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'User guard gagal diperbarui: ' . $e->getMessage());
        }
    }

    public function update_user($data, $guardId) 
    {
        
        try {
            DB::beginTransaction();
            $user = User::where('guard_id', $guardId)->firstOrFail();

            $data_user = [
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => $user->status,
                'guard_id' => $guardId,
                'no_badge' => $data['badge_number'],
                'created_at' => $user->created_at,
                'updated_at' => now(),
            ];

            if($data['password']){
                $data_user['password'] = $data['password'];
            }

            $user->update($data_user);
            DB::commit();

            insert_audit_log('Automated update data user after data guard was updated');
            redis_reset_api('guard');
            return redirect()->route('guard.index')->with('success', 'User guard berhasil diperbarui');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('GuardController update_user() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'User guard gagal diperbarui: ' . $e->getMessage());
        }   
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guard  $guard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guard $guard)
    {
        try {
            DB::beginTransaction();

            // Jika Guard memiliki hubungan dengan model User, hapus User terkait
            if ($guard->user) {
                $guard->user->delete();
            }

            // Hapus hubungan many-to-many dengan projects jika ada
            // $guard->projects()->detach();

            // if ($guard->img_avatar) {
            //     $image = $guard->img_avatar;
            //     if (file_exists(public_path('gambar/guard/' . $image))) {
            //         unlink(public_path('gambar/guard/' . $image));
            //     }
            // }

            // Hapus data Guard
            $guard->delete();

            DB::commit();

            insert_audit_log('Delete data guard');
            return redirect()->route('guard.index')->with('success', 'Guard berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('GuardController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'User guard gagal dihapus: ' . $e->getMessage());
        }
    }


    public function datatable()
    {
        $data = Guard::with('shift', 'pleton')->get(); // Assuming relationships with Pleton and Shift

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('badge_number', function (Guard $guard) {
                return $guard->badge_number;
            })
            ->addColumn('name', function (Guard $guard) {
                return $guard->name;
            })
            ->addColumn('email', function (Guard $guard) {
                return $guard->email;
            })
            ->addColumn('gender', function (Guard $guard) {
                return $guard->gender;
            })
            ->addColumn('dob', function (Guard $guard) {
                return $guard->dob ? date('d M Y', strtotime($guard->dob)) : '-';
            })
            ->addColumn('pleton', function (Guard $guard) {
                return $guard->pleton->name ?? '-'; // Displaying the name of the Pleton
            })
            ->addColumn('shift', function (Guard $guard) {
                return $guard->shift->name ?? '-'; // Displaying the name of the Shift
            })
            ->addColumn('action', function (Guard $guard) {
                return [
                    'showurl' => route('guard.show', $guard->id),
                    'editurl' => route('guard.edit', $guard->id),
                    'deleteurl' => route('guard.destroy', $guard->id)
                ];
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
