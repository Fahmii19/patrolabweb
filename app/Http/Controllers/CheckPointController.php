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
        $data['title'] = "Daftar Area Checkpoint";
        return view('super-admin.check-point.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Area Checkpoint";
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
                'name' => 'required|string',
                'location' => 'required|string',
                'location_long_lat' => 'required|string',
                'danger_status' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $currentTime = date('His');
            $capitalizeName = strtoupper($request->name);
            $data['qr_code'] = str_replace(' ','',$currentTime.$capitalizeName);
            $data['status'] = 'ACTIVED';

            CheckPoint::create($data);
            DB::commit();
            return redirect()->route('check-point.index')->with('success', 'Checkpoint Berhasil Ditambahkan');
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
    public function edit($id)
    {
        $data['title'] = "Edit Data Checkpoint";
        $data['round'] = Round::all();
        $data['checkpoint'] = CheckPoint::findOrFail($id);
        return view('super-admin.check-point.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CheckPoint  $checkPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'round_id' => 'required|numeric',
                'name' => 'required|string',
                'location' => 'required|string',
                'location_long_lat' => 'required|string',
                'danger_status' => 'required',
                'status' => 'nullable|in:ACTIVED,INACTIVED',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data['status'] = $data['status'] ?? 'INACTIVED';

            $checkpoint = CheckPoint::find($id);
            $action = $checkpoint->update($data);
            DB::commit();

            if ($action) {
                return redirect()->route('check-point.index')->with('success', 'Checkpoint berhasil diupdate');
            }
            DB::rollback();
            return redirect()->back()->with('error', 'checkpoint gagal diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('CheckpointController update ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CheckPoint  $checkPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        try {
            DB::beginTransaction();
            CheckPoint::find($id)->delete();
            DB::commit();
            return redirect()->route('check-point.index')->with('success', 'Checkpoint Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckPoint destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = CheckPoint::with('round')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('qr_code', '{{$qr_code}}')
            ->addColumn('location', '{{$location}}')
            ->addColumn('location_long_lat', '{{$location_long_lat}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('danger_status', '{{$danger_status}}')
            ->addColumn('round', '{{$round_id ? $round["rute"] : "-"}}')
            ->addColumn('action', function (CheckPoint $checkpoint) {
                $data = [
                    'editurl' => route('check-point.edit', $checkpoint->id),
                    'deleteurl' => route('check-point.destroy', $checkpoint->id)
                ];
                return $data;
            })
            ->toJson();
    }

    public function by_round(Request $request, $id)
    {
        $old = [];
        if ($request->id_round) {
            $old = $request->id_round;
        }

        $round = Round::with(['wilayah', 'project', 'area'])->find($id);
        $checkpoint = Round::find($id)->checkpoint;

        if ($checkpoint->count() <= 0) {
            return response()->json([
                "status" => "false",
                "messege" => "gagal mengambil data checkpoint",
                "data" => []
            ], 404);
        }

        $html = '';
        for ($i=0; $i < $checkpoint->count(); $i++) {
            $badge = $checkpoint[$i]['status'] == "ACTIVED" ? "badge-success" : "badge_danger";
            $html .= '<tr>'.
                '<th scope="row">'. $i + 1 .'</th>'.
                '<td>'. $checkpoint[$i]['name'] . '</td>'.
                '<td>'. $round['wilayah']['nama'] . '</td>'.
                '<td>'. $round['project']['name'] . '</td>'.
                '<td>'. $round['area']['name'] . '</td>'.
                '<td><span class="badge '.$badge.'">'. $checkpoint[$i]['status'] . '</span></td>'.
                '<td>'.
                    '<form method="post" action="'.route("checkpoint-remove-round",$checkpoint[$i]['id']).'" class="d-inline" id="delete_form'.$checkpoint[$i]['id'].'">
                    ' . csrf_field() . '  
                    ' . method_field("delete") . ' 
                    <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button" form-id=#delete_form'.$checkpoint[$i]['id'].'>'.
                        'Hapus dari round'.
                    '</button>'.
                    '</form>'.
                '</td>'.
            '</tr>';
        }

        return response()->json([
            "status" => "true",
            "messege" => "berhasil mengambil data checkpoint",
            "data" => [$html]
        ], 200);
    }

    public function remove_round($id)
    {
        try {
            DB::beginTransaction();
            CheckPoint::find($id)->update(['round_id' => null]);
            DB::commit();
            return redirect()->route('round.detail')->with('success', 'Round Pada Checkpoint Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckPoint destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable_without_round()
    {
        $data = CheckPoint::whereNull('round_id')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->escapeColumns('active')
        ->addColumn('name', '{{$name}}')
        ->addColumn('location', '{{$location}}')
        ->addColumn('status', '{{$status}}')
        ->addColumn('danger_status', '{{$danger_status}}')
        ->addColumn('action', function(CheckPoint $checkpoint) {
            return route('checkpoint-update-round', $checkpoint->id);
        })
        ->toJson();
    }

    public function update_round(Request $request, $id) 
    {
        try{
            $validator = Validator::make($request->all(), [
                'edit_nama' => 'required|string',
                'edit_id_round' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Nama checkpoint dan round tidak boleh kosong');
            }

            $round_id = $request->input('edit_id_round');
            DB::beginTransaction();
            CheckPoint::find($id)->update(['round_id' => $round_id]);
            DB::commit();
            return redirect()->route('round.detail')->with('success', 'Round Pada Checkpoint Berhasil Diperbaharui');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('CheckpointController update ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
