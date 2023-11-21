<?php

namespace App\Http\Controllers;

use Throwable;
// use App\Models\Guard;
use App\Models\Pleton;
use App\Models\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PletonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pletonData = Pleton::withCount('guards')->get();
        // dd($pletonData);

        $data['title'] = "Daftar Pleton";
        return view('super-admin.pleton-page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd("hahahahaha");
        $data['title'] = 'Tambah Pleton';
        $data['pletons'] = Pleton::all();
        $data['guards'] = Guard::all();
        // $data['guards'] = Guard::get();
        // dd($data);
        return view('super-admin.pleton-page.create', $data);
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
                'id_pleton' => 'required',
                'id_guard' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $validator->validated();

            $guard = Guard::find($request->id_guard);
            // dd($guard);

            $data['pleton_id'] = $request->id_pleton;
            // dd($data);
            $guard->update($data);
            DB::commit();
            return redirect()->route('pleton.index')->with('success', 'Data Berhasil Ditambah');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('PletonController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
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
        // Mengambil data Pleton berdasarkan ID
        $pleton = Pleton::findOrFail($id);
        $title = "Detail Pleton"; // Judul halaman

        // Mengirim data ke view
        return view('super-admin.pleton-page.show', compact('pleton', 'title'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pleton = Pleton::findOrFail($id); // Find the Pleton by ID or fail
        $guards = Guard::all(); // Assuming you need a list of guards for a dropdown

        // Pass the necessary data to the view
        return view('super-admin.pleton-page.edit', [
            'title' => 'Edit Pleton',
            'pleton' => $pleton,
            'guards' => $guards
        ]);
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
        // Validasi request
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_badge' => 'required|string|max:255|unique:pleton,no_badge,' . $id,
            // Tambahkan aturan validasi lainnya jika diperlukan
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Mencari dan memperbarui Pleton
        $pleton = Pleton::findOrFail($id);
        $pleton->nama = $request->nama;
        $pleton->no_badge = $request->no_badge;
        // Update field lainnya jika ada
        $pleton->save();

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('pleton.index')->with('success', 'Pleton berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mencari data Pleton berdasarkan ID
        $pleton = Pleton::findOrFail($id);

        // Melakukan penghapusan data
        $pleton->delete();

        // Mengirimkan pesan sukses setelah penghapusan
        return redirect()->route('pleton.index')->with('success', 'Pleton berhasil dihapus');
    }


    public function datatable()
    {
        $data = Pleton::withCount('guards')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function ($pleton) {
                return $pleton->nama;
            })
            ->addColumn('no_badge', function ($pleton) {
                return $pleton->no_badge;
            })
            ->addColumn('guards_count', function ($pleton) {
                return $pleton->guards_count;
            })
            ->addColumn('action', function ($pleton) {
                return [
                    'showurl' => route('pleton.show', $pleton->id),
                    'editurl' => route('pleton.edit', $pleton->id),
                    'deleteurl' => route('pleton.destroy', $pleton->id)
                ];
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
