<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Wilayah";
        return view('super-admin.wilayah.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Wilayah";
        return view('super-admin.wilayah.create', $data);
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
            $data = $request->validate([
                'kode' => ['required', 'unique:wilayahs'],
                'nama' => ['required', 'string']
            ]);

            $action = Wilayah::create($data);
            DB::commit();

            if ($action) {
               return redirect()->route('wilayah.index')->with('success','data wilayah berhasil disimpan');
            }
            DB::rollback();
            return redirect()->back()->with('error', 'data wilayah gagal disimpan');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('WilayahController store '.$e->getMessage());
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wilayah  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function show(Wilayah $wilayah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wilayah  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function edit(Wilayah $wilayah)
    {
        $data['title'] = "Edit Data Wilayah";
        $data['wilayah'] = $wilayah;
        return view('super-admin.wilayah.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wilayah  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wilayah $wilayah)
    {
        try {
            DB::beginTransaction();
            $unique = 'unique:wilayahs';

            if($request->kode == $wilayah->kode){
                $unique = '';
            }
            $data = $request->validate([
                'kode' => ['required', $unique],
                'nama' => ['required', 'string']
            ]);

            $action = $wilayah->update($data);
            DB::commit();

            if ($action) {
                return redirect()->route('wilayah.index')->with('success', 'data wilayah berhasil diupdate');
            }
            DB::rollback();
            return redirect()->back()->with('error', 'data wilayah gagal diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('WilayahController update ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wilayah  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wilayah $wilayah)
    {
        try {
            DB::beginTransaction();
           
            $action = $wilayah->delete();
            DB::commit();

            if ($action) {
                return redirect()->route('wilayah.index')->with('success', 'data wilayah berhasil dihapus');
            }
            DB::rollback();
            return redirect()->back()->with('error', 'data wilayah gagal dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('WilayahController destroy ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable() {
        $data = Wilayah::all();
        return DataTables::of($data)
        ->addIndexColumn()
        ->escapeColumns('active')
        ->addColumn('kode','{{$kode}}')
        ->addColumn('nama', '{{$nama}}')
        ->addColumn('action', function(Wilayah $wilayah){
            $data = [
                'editurl' => route('wilayah.edit',$wilayah->id),
                'deleteurl' => route('wilayah.destroy',$wilayah->id)
            ];
            return $data;
        })
        ->toJson(); 
    }
}
