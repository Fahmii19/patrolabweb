<?php

namespace App\Http\Controllers;

use App\Models\PivotGuardProject;
use Throwable;
use App\Models\Shift;
use App\Models\Guard;
use App\Models\User;
use App\Models\Pleton;
use App\Models\Wilayah;
use App\Models\Area;
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
        $data['pletons'] = Pleton::all();
        $data['shifts'] = Shift::all();
        $data['wilayah'] = Wilayah::all();
        $data['area'] = Area::all();
        // dd($data['area']);
        // dd($data);
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
        // Validasi input form
        $validatedData = $request->validate([
            'badge_number' => 'required|string|max:255|unique:guard,badge_number',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:guard,email',
            'gender' => 'required|in:MALE,FEMALE',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'wa' => 'required|string',
            'pleton_id' => 'required|numeric|exists:pleton,id',
            'shift_id' => 'required|numeric|exists:shift,id',
        ]);

        try {
            DB::beginTransaction();

            // Create a new Guard instance with validated data
            $guard = new Guard([
                'badge_number' => $validatedData['badge_number'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'dob' => $validatedData['dob'],
                'address' => $validatedData['address'],
                'wa' => $validatedData['wa'],
                'pleton_id' => $validatedData['pleton_id'],
                'shift_id' => $validatedData['shift_id'],
                // Password handling, if necessary
            ]);

            $guard->save();

            DB::commit();

            return redirect()->route('guard.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();

            // Return to the form with an error message
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
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
        $data['pletons'] = Pleton::all();
        $data['shifts'] = Shift::all();
        $data['guard'] = $guard;

        // dd($data);
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
        // Validasi input form
        $validatedData = $request->validate([
            'badge_number' => 'required|string|max:255|unique:guard,badge_number,' . $guard->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:guard,email,' . $guard->id,
            'gender' => 'required|in:MALE,FEMALE',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'wa' => 'required|string',
            'pleton_id' => 'required|numeric|exists:pleton,id',
            'shift_id' => 'required|numeric|exists:shift,id',
            'password' => 'nullable|string|min:8',
        ]);

        try {
            DB::beginTransaction();

            // Update Guard instance with validated data
            $guard->update([
                'badge_number' => $validatedData['badge_number'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'dob' => $validatedData['dob'],
                'address' => $validatedData['address'],
                'wa' => $validatedData['wa'],
                'pleton_id' => $validatedData['pleton_id'],
                'shift_id' => $validatedData['shift_id'],
            ]);

            DB::commit();

            return redirect()->route('guard.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
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
            $guard->projects()->detach();

            // Hapus data Guard
            $guard->delete();

            DB::commit();

            return redirect()->route('guard.index')->with('success', 'Guard berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus Guard: ' . $e->getMessage());
        }
    }


    public function datatable()
    {
        $data = Guard::with('shift', 'pleton')->get(); // Assuming relationships with Pleton and Shift

        // dd($data);

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
                return $guard->dob ? date('d M Y', strtotime($guard->dob)) : '';
            })
            ->addColumn('pleton', function (Guard $guard) {
                return $guard->pleton->name ?? 'N/A'; // Displaying the name of the Pleton
            })
            ->addColumn('shift', function (Guard $guard) {
                return $guard->shift->name ?? 'N/A'; // Displaying the name of the Shift
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
