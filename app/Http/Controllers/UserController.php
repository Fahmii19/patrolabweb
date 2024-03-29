<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Area;
use App\Models\User;
use App\Models\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar User";
        return view('super-admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah User (Admin Area)";
        $data['area'] = Area::all(); // Data area untuk admin-area
        return view('super-admin.user.create', $data);
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
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'area.*' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            if ($request->area == null) {
                return redirect()->back()->withErrors(['area' => 'Area wajib dipilih, minimal satu']);
            }

            $validator->validated();

            $data_user = [
                'access_area' => implode(',', $request->area),
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => 'ACTIVED',
                'created_at' => now(),
                'updated_at' => null,
            ];

            $user = User::create($data_user);

            $user->assignRole('admin-area');
            DB::commit();

            insert_audit_log('Insert data user');
            return redirect()->route('user.index')->with('success', 'Admin Area berhasil ditambahkan');            
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('UserController store() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Admin Area gagal ditambahkan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = "Edit User";
        $data['user'] = User::find($id);
        $data['area'] = Area::all();

        if (!$data['user']) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Menggunakan variabel $data['user'] yang sudah didefinisikan
        $roleNames = $data['user']->getRoleNames(); 
        return view('super-admin.user.edit', $data, compact('roleNames'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'role' => 'required|string',
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,'. $id,
                'password' => 'nullable',
                'area.*' => 'nullable|string',
                'status' => 'nullable|in:ACTIVED,INACTIVED'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }


            $user = User::find($id);
            if (!$user) {
                throw new Exception('User tidak ditemukan.');
            }

            // Update data user lainnya
            $data = $validator->validated();
            $data_user = [
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => $data['status'] ?? 'INACTIVED',
                'created_at' => $user->created_at,
                'updated_at' => now(),
            ];

            // Check jika hak akses user sebagai admin area
            if ($request->role == 'admin-area') {

                if ($request->area == null) {
                    return redirect()->back()->withErrors(['area' => 'Area wajib dipilih, minimal satu']);
                }

                $data_user['access_area'] = implode(',', $request->area);
            }

            // Check jika password tidak kosong
            if ($request->password) {
                $data_user['password'] = bcrypt($request->password);
            }

            $user->update($data_user);
            DB::commit();

            insert_audit_log('Update data user');
            redis_reset_api('user/spesific/'.$id);
            return redirect()->route('user.index')->with('success', 'User berhasil diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('UserController update() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'User gagal diedit: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            DB::beginTransaction();

            $user->delete();
            DB::commit();

            insert_audit_log('Delete data user');
            redis_reset_api('user/spesific/'.$id);
            return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('UserController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'User gagal dihapus: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = User::with(['data_guard' => function($query){
            $query->select('id', 'badge_number');
        }])->where('id', '!=', 1)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('no_badge', '{{$guard_id ? $data_guard["badge_number"] : "-"}}')
            ->addColumn('access_area', function(User $user) {
                if ($user->access_area) {
                    $list_area = "";
                    $areas = explode(',', $user->access_area);
                    foreach($areas as $item){
                        $area = Area::where('id', $item)->pluck('name');
                        $list_area .= $area[0] . ', ';
                    }

                    return rtrim($list_area, ', ');
                }
                return "-";
            })
            ->addColumn('role', function (User $user) {
                return implode(', ', $user->getRoleNames()->toArray());
            })
            ->addColumn('created_at', function (User $user) {
                return date('d/m/y - H:i:s', strtotime($user->created_at));
            })
            ->addColumn('status', '{{$status}}')
            ->addColumn('action', function (User $user) {
                return [
                    'editurl' => route('user.edit', $user->id),
                    'deleteurl' => route('user.destroy', $user->id)
                ];
            })
        ->toJson();
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
