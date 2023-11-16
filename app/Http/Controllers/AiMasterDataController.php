<?php

namespace App\Http\Controllers;

use App\Models\AiMasterData;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AiMasterDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Master data User AI";
        return view('super-admin.ai-data.index', $data);
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
     * @param  \App\Models\AiMasterData  $aiMasterData
     * @return \Illuminate\Http\Response
     */
    public function show(AiMasterData $aiMasterData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AiMasterData  $aiMasterData
     * @return \Illuminate\Http\Response
     */
    public function edit(AiMasterData $aiMasterData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AiMasterData  $aiMasterData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AiMasterData $aiMasterData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AiMasterData  $aiMasterData
     * @return \Illuminate\Http\Response
     */
    public function destroy(AiMasterData $aiMasterData)
    {
        //
    }

    public function datatable()
    {
        $data = AiMasterData::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('nama', '{{$nama}}')
            ->addColumn('foto', '{{$foto}}')
            ->addColumn('gender', '{{$gender}}')
            ->addColumn('wilayah', '{{$wilayah}}')
            ->addColumn('area', '{{$area}}')
            ->addColumn('action', function (AiMasterData $ai) {
                $data = [
                    'editurl' => route('wilayah.edit', $ai->id),
                    'deleteurl' => route('wilayah.destroy', $ai->id)
                ];
                return $data;
            })
            ->toJson();
    }
}
