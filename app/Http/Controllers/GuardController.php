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
        $data['pleton'] = Pleton::all();
        $data['shift'] = Shift::all();
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
            'no_badge' => 'required|numeric',
            'nama' => 'required|string|max:255',
            'ttl' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'email' => 'required|email|unique:guards,email',
            'wa' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'id_wilayah' => 'required|numeric', // Tambahkan validasi untuk id_wilayah
            'id_area' => 'required|numeric', // Tambahkan validasi untuk id_area
        ]);

        try {
            DB::beginTransaction();

            // Membuat instance baru dari Guard dengan data yang divalidasi
            $guard = Guard::create([
                'no_badge' => $validatedData['no_badge'],
                'nama' => $validatedData['nama'],
                'ttl' => $validatedData['ttl'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'email' => $validatedData['email'],
                'wa' => $validatedData['wa'],
                'alamat' => $validatedData['alamat'],
                'password' => bcrypt($validatedData['password']),
                'id_wilayah' => $validatedData['id_wilayah'],
                'id_area' => $validatedData['id_area'],
            ]);

            DB::commit();

            return redirect()->route('guard.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();

            // Mengembalikan user ke form dengan pesan error
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
        //
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
        $data['wilayah'] = Wilayah::all();
        $data['area'] = Area::all();
        $data['guard'] = $guard;
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
            'no_badge' => 'required|numeric',
            'nama' => 'required|string|max:255',
            'ttl' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'email' => 'required|email|unique:guards,email,' . $guard->id,
            'wa' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'id_wilayah' => 'required|numeric',
            'id_area' => 'required|numeric',
            'password' => 'nullable|string|min:8',
        ]);

        try {
            DB::beginTransaction();

            // Update instance Guard dengan data yang divalidasi
            $guard->update([
                'no_badge' => $validatedData['no_badge'],
                'nama' => $validatedData['nama'],
                'ttl' => $validatedData['ttl'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'email' => $validatedData['email'],
                'wa' => $validatedData['wa'],
                'alamat' => $validatedData['alamat'],
                'id_wilayah' => $validatedData['id_wilayah'],
                'id_area' => $validatedData['id_area'],
                // Perbarui password hanya jika password baru disediakan
                'password' => $validatedData['password'] ? bcrypt($validatedData['password']) : $guard->password,
            ]);

            DB::commit();

            return redirect()->route('guard.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();

            // Mengembalikan user ke form dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guard  $guard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guard $id)
    {
        // try {
        //     DB::beginTransaction();
        //     Guard::find($id)->delete();
        //     DB::commit();
        //     return redirect()->route('guard.index')->with('success', 'Data Berhasil Dihapus');
        // } catch (Throwable $e) {
        //     DB::rollback();
        //     Log::debug('ProjectModelController destroy() ' . $e->getMessage());
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
        try {
            DB::beginTransaction();

            // Hapus Guard
            $id->delete();

            DB::commit();

            return redirect()->route('guard.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();

            // Mengembalikan user ke form dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Guard::all();
        // dd($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('no_badge', '{{$no_badge}}')
            ->addColumn('nama', '{{$nama}}')
            ->addColumn('email', '{{$email}}')
            ->addColumn('created_at', function (Guard $guard) {
                return date('d M y', strtotime($guard->created_at));
            })
            ->addColumn('action', function (Guard $guard) {
                $data = [
                    'showurl' => route('guard.show', $guard->id),
                    'editurl' => route('guard.edit', $guard->id),
                    'deleteurl' => route('guard.destroy', $guard->id)
                ];
                return $data;
            })
            ->toJson();
    }
}
