<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AssetCheckpointLog;
use App\Models\AssetPatrolCheckpointLog;
use App\Models\AssetUnsafeOption;
use App\Models\CheckPoint;
use App\Models\Guard;
use App\Models\PatrolAccidentalLog;
use App\Models\PatrolCheckpointLog;
use Throwable;
use App\Models\SelfPatrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SelfPatrolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Self Patrol';
        // $data['self-patrol'] = PatrolAccidentalLog::all();
        return view('super-admin.self-patrol.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Insert Self Patrol';
        $data['guard'] = Guard::all();
        $data['checkpoint'] = CheckPoint::all();
        $data['unsafeOption'] = AssetUnsafeOption::all();
        return view('super-admin.self-patrol.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $validator = Validator::make($request->all(), [
    //             'id_guard' => 'required|numeric',
    //             'id_checkpoint' => 'required|numeric',
    //             'patrol_date' => 'required',
    //             'patrol_start_time' => 'required',
    //             'patrol_finish_time' => 'required',
    //             'asset_id.*' => 'required|numeric',
    //             'asset_status.*' => 'required|in:SAFE,UNSAFE',
    //             'unsafe_description.*' => 'nullable|string',
    //             'asset_unsafe_option_id.*' => 'nullable|numeric',
    //             'unsafe_image.*' => 'image|mimes:jpeg,png,jpg',
    //         ]);

    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
    //         }

    //         $data = $validator->validated();
    //         $start_time = Carbon::parse($data['patrol_start_time'])->seconds(0);
    //         $finish_time = Carbon::parse($data['patrol_finish_time'])->seconds(0);

    //         $patrol = [
    //             'guard_id' => $data['id_guard'],
    //             'patrol_date' => $data['patrol_date'],
    //             'start_time' => $start_time->format('H:i:s'),
    //             'finish_time' => $finish_time->format('H:i:s'),
    //             'checkpoint_id' => $data['id_checkpoint'],
    //             'created_at' => now(),
    //         ];

    //         $patrolId = PatrolCheckpointLog::insertGetId($patrol);
    //         DB::commit();

    //         if ($patrolId) {
    //             return $this->insert_asset_checkpoint_log($request, $patrolId);
    //         }

    //         DB::rollback();
    //         return redirect()->back()->with('error', 'Gagal melakukan self patrol');
    //     } catch (Throwable $e) {
    //         DB::rollback();
    //         Log::debug('SelfPatrolController store() ' . $e->getMessage());
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    //     // return response()->json($request);
    //     // try {
    //     //     DB::beginTransaction();
    //     //     $validator = Validator::make($request->all(), 
    //     //     [
    //     //         'id_guard' => ['required', 'numeric'],
    //     //         'id_wilayah' => ['required', 'numeric'],
    //     //         'id_wilayah' => ['required', 'numeric'],
    //     //         'id_area' => ['required', 'numeric'],
    //     //         'tanggal' => ['required'],
    //     //         'status_lokasi' => ['required', 'in:aman,kebakaran,pencurian,lain-lain'],
    //     //         'deskripsi' => ['required'],
    //     //         'foto' => ['nullable','array'],
    //     //         'foto.*' => ['image', 'mimes:jpg,png,jpeg,gif', 'max:5000']
    //     //     ]);

    //     //     //return $request->file('foto.0')->getClientOriginalExtension();

    //     //     if($validator->fails()){
    //     //         return response()->json([
    //     //             'status' => false,
    //     //             'message' => 'input tidak valid',
    //     //             'data' => $validator->errors()
    //     //         ],401);
    //     //     }
    //     //     $data = $validator->validated();

    //     //     if($request->hasFile('foto')){
    //     //         $paths = [];
    //     //         $inc_name = 0;
    //     //         foreach ($request->file('foto') as $file) {
    //     //             $inc_name++;
    //     //             $extension = $file->getClientOriginalExtension();
    //     //             $file_name = time() .'-'.$inc_name. '.' . $extension;
    //     //             $path = $file->storeAs(
    //     //                 'self-patrol',
    //     //                 $file_name
    //     //             );
    //     //             array_push($paths,$path);
    //     //         }
    //     //         $data['foto'] = json_encode($paths);
    //     //     }
            
    //     //     $action = SelfPatrol::create($data);
    //     //     DB::commit();
    //     //     return response()->json([
    //     //         'status' => true,
    //     //         'message' => 'data berhasil di simpan',
    //     //         'data' => $action
    //     //     ], 200);

    //     // } catch (Throwable $e) {
    //     //     DB::rollback();
    //     //     Log::debug('SelfPatrol store ' . $e->getMessage());
    //     //     return response()->json([
    //     //         'status' => false,
    //     //         'message' => 'terjadi kesalahan',
    //     //         'data' => [$e->getMessage()]
    //     //     ], 500);
    //     // }
    // }

    // public function insert_asset_checkpoint_log(Request $request, $patrolId){
    //     try {
    //         DB::beginTransaction();

    //         // $result = [];
    //         foreach($request['asset_id'] as $index => $value){
    //             $assetCheckpointLog = new AssetPatrolCheckpointLog();
    //             $assetCheckpointLog->patrol_checkpoint_id = $patrolId;
    //             $assetCheckpointLog->asset_id = $value;
    //             $assetCheckpointLog->status = $request['asset_status'][$index];
    //             $assetCheckpointLog->unsafe_description = $request['unsafe_description'][$index];
    //             $assetCheckpointLog->asset_unsafe_option_id = $request['asset_unsafe_option_id'][$index];
    //             $assetCheckpointLog->created_at = now();

    //             if (isset($request['unsafe_image'][$index])) {
    //                 $file = $request->file('unsafe_image.' . $index);
                
    //                 if ($file->isValid()) {
    //                     $filename = time() . '_' . $file->getClientOriginalName();
    //                     $file->move(public_path('gambar/aset'), $filename);
                
    //                     $assetCheckpointLog->unsafe_image = $filename;
    //                 }
    //             }

    //             $assetCheckpointLog->save();
    //             DB::commit();
    //         }

    //         // return response()->json($result);
    //         return redirect()->route('self-patrol.create')->with('success', 'Data inserted successfully');
    //     } catch (Throwable $e) {
    //         DB::rollback();
    //         Log::debug('SelfPatrolController insert_asset_checkpoint() ' . $e->getMessage());
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    //     // return response()->json([
    //     //     "patrolId" => $patrolId,
    //     //     "asset" => $asset
    //     // ]);
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SelfPatrol  $selfPatrol
     * @return \Illuminate\Http\Response
     */
    public function show(SelfPatrol $selfPatrol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SelfPatrol  $selfPatrol
     * @return \Illuminate\Http\Response
     */
    public function edit(SelfPatrol $selfPatrol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SelfPatrol  $selfPatrol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SelfPatrol $selfPatrol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SelfPatrol  $selfPatrol
     * @return \Illuminate\Http\Response
     */
    public function destroy(SelfPatrol $selfPatrol)
    {
        //
    }

    public function datatable()
    {
        $data = PatrolAccidentalLog::with(['location_condition', 'data_guard', 'pleton', 'shift'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('guard', '{{$data_guard["name"]}}')
            ->addColumn('pleton', '{{$pleton["name"]}}')
            ->addColumn('coordinat', '{{$accidental_long_lat_log}}')
            ->addColumn('description', '{{$description}}')
            ->addColumn('condition', '{{$location_condition_log}}')
            ->addColumn('image', function ($row) {
                $images = $row->images;
                $imgHtml = '';
                // Cek jika file gambar ada
                if ($images) {
                    $url = check_img_path($images);
                } else {
                    $url = asset('gambar/no-image.png'); // Gambar default
                }

                $imgHtml .= '<span class="btn" data-bs-toggle="modal" data-bs-target="#imageModal' . $row->id . '"><img src="' . $url . '" border="0" width="100" class="img-rounded mr-1" align="center" /></span>';
                
                $imgHtml .= '
                    <div class="modal fade" id="imageModal' . $row->id . '" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="' . $url . '" class="img-fluid">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                return $imgHtml;
            })
            ->addColumn('reported_at', function ($data) {
                return date('m/d/Y H:i:s', strtotime($data->created_at));
            })
        ->toJson();
    }

}
