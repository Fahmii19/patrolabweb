<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Exception;
use Throwable;
use App\Models\Aset;
use App\Models\CheckPoint;
use App\Models\CheckpointAssetPatrol;
use App\Models\PatrolArea;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AssetPatrolCheckpointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Daftar Checkpoint Aset Patrol';
        return view('super-admin.checkpoint-aset.index-patrol', $data);
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
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'asset_id' => 'required|numeric',
                'insert_checkpoint' => 'required|numeric',
                'short_desc' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data = [
                'asset_master_id' => $request->asset_id,
                'checkpoint_id' => $request->insert_checkpoint,
                'checkpoint_note' => $request->short_desc,
                'status' => 'ACTIVED',
                'created_at' => now(),
                'updated_at' => null,
            ];

            $action = CheckpointAssetPatrol::create($data);
            $id = $action->id;
            DB::commit();

            insert_audit_log('Insert data asset patrol ' . $request->asset_id . ' to checkpoint ' . $request->insert_checkpoint);
            redis_reset_api('asset-patrol-checkpoint/'.$id);
            return redirect()->route('asset-patrol-detail')->with('success', 'Asset Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckpointAssetPatrol store() error:' . $e->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            CheckpointAssetPatrol::find($id)->delete();
            DB::commit();

            insert_audit_log('Delete asset patrol checkpoint data');
            redis_reset_api('asset-patrol-checkpoint/'.$id);
            return redirect()->route('asset-patrol-detail')->with('success', 'Asset Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckpointAssetPatrol destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function detail()
    {
        $data['title'] = "Detail Asset Checkpoint";
        if (auth()->user()->hasRole('admin-area')) {
            $area_id = explode(',', auth()->user()->access_area);
        
            $data['area'] = Area::whereIn('id', $area_id)->get();
            $data['patrol_area'] = PatrolArea::whereIn('area_id', $area_id)->get();
            $data['round'] = Round::with('patrol_area.area')
                ->whereHas('patrol_area', function ($query) use ($area_id) {
                    $query->whereIn('area_id', $area_id);
                })->get();
            $data['checkpoint'] = CheckPoint::with('round.patrol_area.area')
                ->whereHas('round.patrol_area', function ($query) use ($area_id) {
                    $query->whereIn('area_id', $area_id);
                })->get();
        } else {
            $data['area'] = Area::all();
            $data['patrol_area'] = PatrolArea::all();
            $data['round'] = Round::all();
            $data['checkpoint'] = CheckPoint::all();
        }
        
        return view('super-admin.checkpoint-aset.detail-patrol', $data);
    }

    public function asset_patrol_datatable()
    {
        $data = CheckpointAssetPatrol::with(['checkpoint.round.patrol_area.area'])
        ->select(
            'asset_patrol_checkpoint.checkpoint_id',
            DB::raw('COUNT(asset_patrol_checkpoint.asset_master_id) as jumlah_asset')
        )->groupBy('asset_patrol_checkpoint.checkpoint_id');

        if(auth()->user()->hasRole('admin-area')){
            $area_id = explode(',', auth()->user()->access_area);

            $data->whereHas('checkpoint.round.patrol_area', function ($query) use ($area_id) {
                $query->whereIn('area_id', $area_id);
            });
        }

        $row = $data->get();
        return DataTables::of($row)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('checkpoint_name', '{{$checkpoint["name"]}}')
            ->addColumn('jumlah_asset', '{{$jumlah_asset}}')
            ->addColumn('location', '{{$checkpoint["location"]}}')
            ->addColumn('status', '{{$checkpoint["status"]}}')
        ->toJson();
    }

    public function asset_datatable()
    {
        $query = Aset::where('asset_master_type', 'PATROL');

        $data = $query->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('code', '{{$code}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('type', '{{$asset_master_type}}')
            ->addColumn('status', '{{$status}}')
        ->toJson();
    }

    public function asset_by_checkpoint(Request $request, $id)
    {
        $old = [];
        if ($request->id_checkpoint) {
            $old = $request->id_checkpoint;
        }

        $asset = CheckpointAssetPatrol::with(['asset'])
        ->where('checkpoint_id', $id)
        ->get();

        if ($asset->count() <= 0) {
            return response()->json([
                "status" => "false",
                "messege" => "gagal mengambil data asset",
                "data" => []
            ], 404);
        }

        // return response()->json($asset);
        $html = '';
        for ($i=0; $i < $asset->count(); $i++) {
            $assetStatus = $asset[$i]['status'];
            $assetDetail = $asset[$i]['asset'];
            $badge = ($assetStatus == "ACTIVED") ? "badge-success" : "badge_danger";

            $html .= '<tr>'.
                '<th scope="row">'. $i + 1 .'</th>'.
                '<td>'. $assetDetail['code'] . '</td>'.
                '<td>'. $assetDetail['name'] . '</td>'.
                '<td>'. $assetDetail['short_desc'] . '</td>'.
                '<td>'. $assetDetail['asset_master_type'] . '</td>'.
                '<td>'. ($asset[$i]['checkpoint_note'] ?? '-') . '</td>'.
                '<td><span class="badge '.$badge.'">'. $assetStatus . '</span></td>'.
                '<td>'.
                    '<form method="post" action="'.route("checkpoint-aset-patrol.destroy",$asset[$i]['id']).'" class="d-inline" id="delete_form'.$asset[$i]['id'].'">
                    ' . csrf_field() . '  
                    ' . method_field("delete") . ' 
                    <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button" form-id=#delete_form'.$asset[$i]['id'].'>'.
                        'Hapus dari checkpoint'.
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
}
