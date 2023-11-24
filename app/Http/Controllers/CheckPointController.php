<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Area;
use App\Models\Wilayah;
use App\Models\CheckPoint;
use App\Models\CheckpointAset;
use App\Models\Round;
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
        $data['round'] = Round::all();
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
                    'round_id' => 'required|numeric',
                    'nama' => 'required|string',
                    'lokasi' => 'required|string',
                    'danger_status' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
                }

                $data = $validator->validated();
                $currentTime = date('His');
                $capitalizeName = strtoupper($request->nama);
                $data['kode'] = str_replace(' ','',$currentTime.$capitalizeName);
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
        $data = CheckPoint::with('round')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$nama}}')
            ->addColumn('qr_code', '{{$kode}}')
            ->addColumn('location', '{{$lokasi}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('danger_status', '{{$danger_status}}')
            ->addColumn('round', '{{$round["rute"]}}')
            ->toJson();
    }

    public function by_round(Request $request, $id)
    {
        $old = [];
        if ($request->id_round) {
            $old = $request->id_round;
        }

        $data = Round::find($id)->checkpoint;
        if ($data->count() <= 0) {
            return response()->json([
                "status" => "false",
                "messege" => "gagal mengambil data checkpoint",
                "data" => []
            ], 404);
        }
        $html = '';
        for ($i=0; $i < $data->count(); $i++) {
            $html .= '<tr>'.
                '<th scope="row">'. $i + 1 .'</th>' .
                '<td>'. $data[$i]['nama'] . '</td>' .
            '</tr>';
        }
        return response()->json([
            "status" => "true",
            "messege" => "berhasil mengambil data checkpoint",
            "data" => [$html]
        ], 200);
    }
}
