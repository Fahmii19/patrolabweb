<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Round;
use App\Models\CheckPoint;
use App\Models\AssetUnsafeOption;
use App\Models\CheckpointAssetClient;
use App\Models\CheckpointAssetPatrol;
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
        $data['title'] = "Tambah Checkpoint";
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
            $data['created_at'] = now();
            $data['updated_at'] = null;

            CheckPoint::create($data);
            DB::commit();

            insert_audit_log('Insert data checkpoint');
            return redirect()->route('check-point.index')->with('success', 'Checkpoint berhasil ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckPointController store() error:' . $e->getMessage());
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
        $data['title'] = "Edit Checkpoint";
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

            $checkpoint = CheckPoint::find($id);

            $data = $validator->validated();
            $data['status'] = $data['status'] ?? 'INACTIVED';
            $data['created_at'] = $checkpoint->created_at;
            $data['updated_at'] = now();

            $checkpoint->update($data);
            DB::commit();

            insert_audit_log('Update data checkpoint');
            return redirect()->route('check-point.index')->with('success', 'Checkpoint berhasil diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('CheckpointController update() error:' . $e->getMessage());
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

            insert_audit_log('Delete data checkpoint');
            return redirect()->route('check-point.index')->with('success', 'Checkpoint Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckPoint destroy() error:' . $e->getMessage());
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
            ->addColumn('round', '{{$round_id ? $round["name"] : "-"}}')
            ->addColumn('action', function (CheckPoint $checkpoint) {
                $data = [
                    'editurl' => route('check-point.edit', $checkpoint->id),
                    'deleteurl' => route('check-point.destroy', $checkpoint->id)
                ];
                return $data;
            })
        ->toJson();
    }

    public function select_by_round(Request $request, $id)
    {
        try {
            $old = [];
            if ($id != 0) {
                $old = $request->patrol_area_id;
                $data = CheckPoint::where('round_id', $id)->get();
            } else {
                $data = CheckPoint::all();
            }

            if ($data->count() <= 0) {
                return response()->json([
                    "status" => "false",
                    "messege" => "gagal mengambil data checkpoint",
                    "data" => []
                ], 404);
            }
            $html = '<option value="0" selected>--Semua--</option>';
            foreach ($data as $item) {
                $selected = $item->id == $old ? 'selected' : '';
                $html .= '<option value="' . $item->id . '"' . $selected . '>' . $item->name . '</option>';
            }
            return response()->json([
                "status" => "true",
                "messege" => "berhasil mengambil data checkpoint",
                "data" => [$html]
            ], 200);
        } catch (Throwable $th) {
            Log::debug($th->getMessage());
        }
    }

    public function by_round(Request $request, $id)
    {
        $old = [];
        if ($request->id_round) {
            $old = $request->id_round;
        }

        $round = Round::with(['patrol_area.area'])->find($id);
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
            $badge = $checkpoint[$i]['status'] == "ACTIVED" ? "badge-success" : "badge-danger";
            $html .= '<tr>'.
                '<th scope="row">'. $i + 1 .'</th>'.
                '<td>'. $checkpoint[$i]['name'] . '</td>'.
                '<td>'. $checkpoint[$i]['location'] . '</td>'.
                '<td>'. $round['patrol_area']['name'] . '</td>'.
                '<td>'. $round['patrol_area']['area']['name'] . '</td>'.
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

            insert_audit_log('Delete round from checkpoint '.$id);
            return redirect()->route('round.detail')->with('success', 'Round Pada Checkpoint Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckPointController remove_round() error:' . $e->getMessage());
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
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'edit_nama' => 'required|string',
                'edit_id_round' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Nama checkpoint dan round tidak boleh kosong');
            }

            $round_id = $request->input('edit_id_round');
            CheckPoint::find($id)->update(['round_id' => $round_id]);
            DB::commit();

            insert_audit_log('Update round_id for checkpoint '.$id);
            return redirect()->route('round.detail')->with('success', 'Round Pada Checkpoint Berhasil Diperbaharui');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('CheckPointController update_round() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function get_all_asset(Request $request, $id) {
        try {
            $old = [];
            if ($request->id_checkpoint) {
                $old = $request->id_checkpoint;
            }

            $clientAsset = CheckpointAssetClient::with('asset')->where('checkpoint_id', $id)->get();
            $patrolAsset = CheckpointAssetPatrol::with('asset')->where('checkpoint_id', $id)->get();
            $unsafeOption = AssetUnsafeOption::all();

            if ($clientAsset->count() <= 0 && $patrolAsset->count() <= 0) {
                return response()->json([
                    "status" => "false",
                    "message" => "gagal mengambil data asset",
                    "data" => []
                ], 404);
            }

            $selectUnsafeOption = '';
            if ($unsafeOption->count() > 0) {
                foreach($unsafeOption as $item) {
                    $selectUnsafeOption .= '<option value="'.$item->id.'" '.(old("option_id[]") == $item->id ? "selected" : '').'>'.$item->option_condition.'</option>';
                }
            }

            $html = '';
            foreach($clientAsset as $item){
                $asset_id = $item->asset_master_id;

                if($item->asset->image && file_exists(public_path('gambar/aset/'.$item->asset->image))){
                    $asset_image = asset('gambar/aset/'.$item->asset->image);
                } else {
                    $asset_image = asset('gambar/no-image.png');
                }
                
                $html .= '<div class="accordion-item">' .
                    '<h2 class="accordion-header" id="heading'.$asset_id.'">'.
                        '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$asset_id.'" aria-expanded="false" aria-controls="collapse'.$asset_id.'">'.
                            $item->asset->name . ' (' .$item->asset->code. ')' . ' - ' . $item->asset->asset_master_type .
                        '</button>'.
                    '</h2>'.
                    '<div id="collapse'.$asset_id.'" class="accordion-collapse collapse" aria-labelledby="heading'.$asset_id.'">'.
                        '<div class="accordion-body">'.
                            '<div class="row g-3 align-item-start">'.
                                '<div class="col-12 col-sm-6 col-xl-4">'.
                                    '<img src="'.$asset_image.'" class="img-fluid img-rounded" alt="img asset">'.
                                '</div>'.
                                '<div class="col-12 col-sm-6 col-xl-8">'.
                                    '<div class="mb-3">'.
                                        '<input type="hidden" name="asset_id[]" value="'.$asset_id.'">'.
                                        '<label for="assetStatus'.$asset_id.'" class="form-label">Status Asset<span class="text-danger">*</span></label>'.
                                        '<select class="form-select '. (isset($errors) && $errors->has("asset_status[]") ? 'is-invalid' : '') . '" name="asset_status[]" data-unsafe-form="#unsafeForm'.$asset_id.'" id="assetStatus'.$asset_id.'" onchange="selectStatus(event)">'.
                                            '<option value="" selected disabled>--Pilih--</option>'.
                                            '<option value="SAFE"> SAFE </option>'.
                                            '<option value="UNSAFE"> UNSAFE </option>'.
                                        '</select>'.
                                    '</div>'.
                                    '<div class="d-none" id="unsafeForm'.$asset_id.'">'.
                                        '<div class="mb-3">'.
                                            '<input type="hidden" name="asset_unsafe_option_id[]">'.
                                            '<label for="unsafeId'.$asset_id.'" class="form-label">Unsafe Option<span class="text-danger">*</span></label>'.
                                            '<select class="form-select '. (isset($errors) && $errors->has("option_id[]") ? 'is-invalid' : '') . '" name="option_id[]" id="unsafeId'.$asset_id.'" onchange="selectOption(event)">'.
                                                '<option value="" selected disabled>--Pilih--</option>'.
                                                $selectUnsafeOption .
                                            '</select>'.
                                        '</div>'.
                                        '<div class="mb-3">'.
                                            '<label for="unsafeDesc'.$asset_id.'" class="form-label">Deskripsi <span class="text-danger">*</span></label>'.
                                            '<input type="text" class="form-control '. (isset($errors) && $errors->has("unsafe_description[]") ? 'is-invalid' : '') . '" name="unsafe_description[]" id="unsafeDesc'.$asset_id.'" value="'.old('unsafe_description[]').'" placeholder="Deskripsi">'.
                                            (isset($errors) && $errors->has('unsafe_description[]') ? '<span class="text-danger d-block">{{$message}}</span>' : '').
                                        '</div>'.
                                        '<div class="mb-3">'.
                                            '<label for="unsafeImage'.$asset_id.'" class="form-label">Gambar Aset <span class="text-danger">*</span></label>'.
                                            '<input type="file" class="form-control '. (isset($errors) && $errors->has("unsafe_image[]") ? 'is-invalid' : '') . '" name="unsafe_image[]" id="unsafeImage'.$asset_id.'">'.
                                            (isset($errors) && $errors->has('unsafe_image[]') ? '<span class="text-danger d-block">{{$message}}</span>' : '').
                                        '</div>'.
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>';
            }
            foreach($patrolAsset as $item){
                $asset_id = $item->asset_master_id;
                if($item->asset->image && file_exists(public_path('gambar/aset/'.$item->asset->image))){
                    $asset_image = asset('gambar/aset/'.$item->asset->image);
                } else {
                    $asset_image = asset('gambar/no-image.png');
                }
                $html .= '<div class="accordion-item">' .
                    '<h2 class="accordion-header" id="heading'.$asset_id.'">'.
                        '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$asset_id.'" aria-expanded="false" aria-controls="collapse'.$asset_id.'">'.
                            $item->asset->name . ' (' .$item->asset->code. ')' . ' - ' . $item->asset->asset_master_type .
                        '</button>'.
                    '</h2>'.
                    '<div id="collapse'.$asset_id.'" class="accordion-collapse collapse" aria-labelledby="heading'.$asset_id.'">'.
                        '<div class="accordion-body">'.
                            '<div class="row g-3 align-item-start">'.
                                '<div class="col-12 col-sm-6 col-xl-4">'.
                                    '<img src="'.$asset_image.'" class="img-fluid img-rounded" alt="img asset">'.
                                '</div>'.
                                '<div class="col-12 col-sm-6 col-xl-8">'.
                                '<div class="mb-3">'.
                                        '<input type="hidden" name="asset_id[]" value="'.$asset_id.'">'.
                                        '<label for="assetStatus'.$asset_id.'" class="form-label">Status Asset<span class="text-danger">*</span></label>'.
                                        '<select class="form-select '. (isset($errors) && $errors->has("asset_status[]") ? 'is-invalid' : '') . '" name="asset_status[]" data-unsafe-form="#unsafeForm'.$asset_id.'" id="assetStatus'.$asset_id.'" onchange="selectStatus(event)">'.
                                            '<option value="" selected disabled>--Pilih--</option>'.
                                            '<option value="SAFE"> SAFE </option>'.
                                            '<option value="UNSAFE"> UNSAFE </option>'.
                                        '</select>'.
                                    '</div>'.
                                    '<div class="d-none" id="unsafeForm'.$asset_id.'">'.
                                        '<div class="mb-3">'.
                                            '<input type="hidden" name="asset_unsafe_option_id[]">'.
                                            '<label for="unsafeId'.$asset_id.'" class="form-label">Unsafe Option<span class="text-danger">*</span></label>'.
                                            '<select class="form-select '. (isset($errors) && $errors->has("option_id[]") ? 'is-invalid' : '') . '" name="option_id[]" id="unsafeId'.$asset_id.'" onchange="selectOption(event)">'.
                                                '<option value="" selected disabled>--Pilih--</option>'.
                                                $selectUnsafeOption .
                                            '</select>'.
                                        '</div>'.
                                        '<div class="mb-3">'.
                                            '<label for="unsafeDesc'.$asset_id.'" class="form-label">Deskripsi <span class="text-danger">*</span></label>'.
                                            '<input type="text" class="form-control '. (isset($errors) && $errors->has("unsafe_description[]") ? 'is-invalid' : '') . '" name="unsafe_description[]" id="unsafeDesc'.$asset_id.'" value="'.old('unsafe_description[]').'" placeholder="Deskripsi">'.
                                            (isset($errors) && $errors->has('unsafe_description[]') ? '<span class="text-danger d-block">{{$message}}</span>' : '').
                                        '</div>'.
                                        '<div class="mb-3">'.
                                            '<label for="unsafeImage'.$asset_id.'" class="form-label">Gambar Aset <span class="text-danger">*</span></label>'.
                                            '<input type="file" class="form-control '. (isset($errors) && $errors->has("unsafe_image[]") ? 'is-invalid' : '') . '" name="unsafe_image[]" id="unsafeImage'.$asset_id.'">'.
                                            (isset($errors) && $errors->has('unsafe_image[]') ? '<span class="text-danger d-block">{{$message}}</span>' : '').
                                        '</div>'.
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>';
            }

            return response()->json([
                "status" => "true",
                "messege" => "berhasil mengambil data asset",
                "data" => [$html],
            ], 200);
        } catch (Throwable $th) {
            Log::debug('CheckPointController get_all_asset() error:' . $th->getMessage());
        }
    }
}
