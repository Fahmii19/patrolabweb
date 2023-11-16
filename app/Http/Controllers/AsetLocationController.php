<?php

namespace App\Http\Controllers;

use App\Models\AsetLocation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AsetLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Master data Lokasi Aset";
        return view('super-admin.aset-location.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AsetLocation  $asetLocation
     * @return \Illuminate\Http\Response
     */
    public function show(AsetLocation $asetLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AsetLocation  $asetLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(AsetLocation $asetLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AsetLocation  $asetLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AsetLocation $asetLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AsetLocation  $asetLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(AsetLocation $asetLocation)
    {
        //
    }

    public function datatable()
    {
        $data = AsetLocation::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('kode', '{{$kode}}')
            ->addColumn('id_aset', '{{$id_aset}}')
            ->addColumn('id_wilayah', '{{$id_wilayah}}')
            ->addColumn('id_area', '{{$id_area}}')
            ->addColumn('jenis_aset', '{{$jenis_aset}}')
            ->addColumn( 'tanggal_pembelian', '{{$tanggal_pembelian}}')
            ->addColumn('keterangan', '{{$keterangan}}')
            ->addColumn('foto', '{{$foto}}')
            ->addColumn('jumlah', '{{$jumlah}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('action', function (AsetLocation $al) {
                $data = [
                    'editurl' => route('aset-location.edit', $al->id),
                    'deleteurl' => route('aset-location.destroy', $al->id)
                ];
                return $data;
            })
            ->toJson();
    }
}
