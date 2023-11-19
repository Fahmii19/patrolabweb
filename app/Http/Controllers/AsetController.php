<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Aset::all();

        $data['title'] = "Master data Aset";
        return view('super-admin.aset.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Aset";

        return view('super-admin.aset.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'status' => 'required',
        ]);


        $aset = new Aset();
        $aset->kode = $request->kode;
        $aset->nama = $request->nama;
        $aset->status = $request->status;
        $aset->save();

        return redirect()->route('aset.index')->with('success', 'Data Aset berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function show(Aset $aset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function edit(Aset $aset)
    {
        $data['title'] = "Edit Data Aset";
        $data['aset'] = $aset;
        return view('super-admin.aset.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aset $aset)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'status' => 'required',
        ]);

        $aset->kode = $request->kode;
        $aset->nama = $request->nama;
        $aset->status = $request->status;
        $aset->save();

        return redirect()->route('aset.index')->with('success', 'Data Aset berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aset $aset)
    {
        // hapus data
        $aset->delete();
        return redirect()->route('aset.index')->with('success', 'Data Aset berhasil dihapus');
    }

    public function datatable()
    {
        $data = Aset::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('kode', '{{$kode}}')
            ->addColumn('nama', '{{$nama}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('action', function (Aset $aset) {
                $data = [
                    'editurl' => route('aset.edit', $aset->id),
                    'deleteurl' => route('aset.destroy', $aset->id)
                ];
                return $data;
            })
            ->toJson();
    }
}
