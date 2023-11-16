<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Area;
use App\Models\Wilayah;
use App\Models\CheckPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CheckPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Area CheckPoint";
        return view('super-admin.check-point.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Area CheckPoint";
        $data['wilayah'] = Wilayah::all();
        $data['area'] = Area::all();
        return view('super-admin.check-point.create', $data);
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
                    'id_wilayah' => 'required|numeric',
                    'id_project' => 'required|numeric',
                    'id_area' => 'required|numeric',
                    'nama' => 'required',
                    'lokasi' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
                }
                $nama_area = Area::find($request->id_area)->nama;
                $data = $validator->validated();
                $data['kode'] = str_replace(' ','',$nama_area.$request->nama);
                $data['status'] = 'aktif';

                CheckPoint::create($data);
                DB::commit();
                return redirect()->route('check-point.index')->with('success', 'Data Berhasil Ditambahkan');
            } catch (Throwable $e) {
                DB::rollback();
                Log::debug('CheckPointController store() ' . $e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CheckPoint  $checkPoint
     * @return \Illuminate\Http\Response
     */
    public function show(CheckPoint $checkPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CheckPoint  $checkPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(CheckPoint $checkPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CheckPoint  $checkPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CheckPoint $checkPoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CheckPoint  $checkPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(CheckPoint $checkPoint)
    {
        //
    }

    public function datatable()
    {
        $data = CheckPoint::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('qr_code', '{{$qr_code}}')
            ->addColumn('location_long_lat', '{{$location_long_lat}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('danger_status', '{{$danger_status}}')
            ->addColumn('id_round', function (CheckPoint $checkpoints) {
                return $checkpoints->round->name ?? '-';
            })
            ->toJson();
    }
}
