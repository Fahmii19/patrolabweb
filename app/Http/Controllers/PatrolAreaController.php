<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Area;
use App\Models\PatrolArea;
use App\Models\PatrolAreaDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PatrolAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Patrol Area";
        return view('super-admin.patrol-area.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Patrol Area";

        if (auth()->user()->hasRole('admin-area')) {
            $area_ids = explode(',', auth()->user()->access_area);
        
            $data['area'] = Area::whereIn('id', $area_ids)->get();
        } else {
            $data['area'] = Area::all();
        }
        return view('super-admin.patrol-area.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            // Validator untuk patrol area
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|unique:patrol_area',
                'name' => 'required|string',
                'location_long_lat' => 'nullable|string',
                'img_location' => 'image|mimes:jpeg,png,jpg',
                'area_id' => 'required|numeric',
                'description' => 'nullable|string',
                'img_desc_location.*' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            // Menangani upload thumbnail patrol area
            $filename = null;
            if ($request->hasFile('img_location')) {
                $file = $request->file('img_location');

                $fileName = $file->getClientOriginalName();
                $fileContent = file_get_contents($file->getRealPath());
                $response = upload_image_api($fileContent, $fileName);

                $result = json_decode($response, true);
                $filename = $result['message'];
            }

            $validated = $validator->validated();

            $data = [
                'code' => $validated['code'],
                'name' => $validated['name'],
                'location_long_lat' => $validated['location_long_lat'],
                'img_location' => $filename,
                'status' => 'ACTIVED',
                'area_id' => $validated['area_id'],
                'created_at' => now(),
                'updated_at' => null,
            ];

            $patrolAreaId = PatrolArea::insertGetId($data);
            DB::commit();
            
            insert_audit_log('Insert data patrol area');
            return $this->store_desc($request, $patrolAreaId);
        } catch(Exception $e){
            DB::rollback();
            Log::error('PatrolAreaController store() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Patrol Area gagal disimpan: ' . $e->getMessage());
        }
    }

    public function store_desc(Request $request, $patrolAreaId)
    {
        try{
            DB::beginTransaction();
            
            // Menangani upload gambar deskripsi patrol area
            $filenames = [];
            if ($request->hasFile('img_desc_location')) {
                foreach ($request->file('img_desc_location') as $file) {
                    $fileName = $file->getClientOriginalName();
                    $fileContent = file_get_contents($file->getRealPath());
                    $response = upload_image_api($fileContent, $fileName);

                    $result = json_decode($response, true);
                    $filenames[] = $result['message'];
                }
            }

            $imgDescLocation = implode(',', $filenames);

            $desc = [
                'description' => $request->description,
                'img_desc_location' => $imgDescLocation,
                'patrol_area_id' => $patrolAreaId,
                'created_at' => now(),
                'updated_at' => null,
            ];
            
            PatrolAreaDescription::create($desc);
            DB::commit();

            insert_audit_log('Automated insert data patrol area description after insert patrol area');
            return redirect()->route('patrol-area.index')->with('success', 'Patrol Area berhasil disimpan');   
        } catch(Exception $e) {
            DB::rollback();
            Log::error('PatrolAreaController store_desc() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Deskripsi Patrol Area gagal disimpan: ' . $e->getMessage());
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
        $data['title'] = "Edit Patrol Area";
        $data['patrol_area'] = PatrolArea::with('area')->find($id);

        if (!$data['patrol_area']) {
            return redirect()->back()->with('error', 'Patrol Area tidak ditemukan.');
        }

        $data['patrol_area_desc'] = PatrolAreaDescription::where('patrol_area_id', $data['patrol_area']->id)->first();

        return view('super-admin.patrol-area.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = "Edit Patrol Area";
        $data['patrol_area'] = PatrolArea::find($id);
        if (auth()->user()->hasRole('admin-area')) {
            $area_ids = explode(',', auth()->user()->access_area);
        
            $data['area'] = Area::whereIn('id', $area_ids)->get();
        } else {
            $data['area'] = Area::all();
        }

        if (!$data['patrol_area']) {
            return redirect()->back()->with('error', 'Patrol Area tidak ditemukan.');
        }

        // $data['patrol_area_desc'] = PatrolAreaDescription::where('patrol_area_id', $data['patrol_area']->id)->first();
        $data['patrol_area_desc'] = PatrolAreaDescription::firstOrNew(['patrol_area_id' => $data['patrol_area']->id]);

        return view('super-admin.patrol-area.edit', $data);
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
        try{
            DB::beginTransaction();

            // Validator untuk patrol area
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|unique:patrol_area,code,'.$id,
                'name' => 'required|string',
                'location_long_lat' => 'nullable|string',
                'img_location' => 'nullable|image|mimes:jpeg,png,jpg',
                'area_id' => 'required|numeric',
                'status' => 'nullable|string|in:ACTIVED,INACTIVED',
                'description' => 'nullable|string',
                'img_desc_location.*' => 'nullable|image|mimes:jpeg,png,jpg',
            ]);


            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $patrolArea = PatrolArea::find($id);

            // Menangani upload thumbnail patrol area
            $filename = $patrolArea->img_location;
            if ($request->hasFile('img_location')) {
                $file = $request->file('img_location');
                
                $fileName = $file->getClientOriginalName();
                $fileContent = file_get_contents($file->getRealPath());
                $response = upload_image_api($fileContent, $fileName);

                $result = json_decode($response, true);
                $filename = $result['message'];
            }

            $validated = $validator->validated();

            $data = [
                'code' => $validated['code'],
                'name' => $validated['name'],
                'location_long_lat' => $validated['location_long_lat'],
                'img_location' => $filename,
                'status' => $validated['status'] ?? 'INACTIVED',
                'area_id' => $validated['area_id'],
                'created_at' => $patrolArea->created_at,
                'updated_at' => now(),
            ];

            $patrolArea->update($data);
            DB::commit();
            
            insert_audit_log('Update data patrol area');
            return $this->update_desc($request, $id);
        } catch(Exception $e){
            DB::rollback();
            Log::error('PatrolAreaController update() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Patrol Area gagal diubah: ' . $e->getMessage());
        }
    }

    public function update_desc(Request $request, $patrolAreaId)
    {
        try{
            DB::beginTransaction();
            
            $patrolAreaDesc = PatrolAreaDescription::where('patrol_area_id', $patrolAreaId)->first();
            $currentImages = explode(',', $patrolAreaDesc->img_desc_location);

            // Menangani upload gambar deskripsi patrol area
            if ($request->hasFile('img_desc_location')) {
                foreach ($request->file('img_desc_location') as $file) {
                    $fileName = $file->getClientOriginalName();
                    $fileContent = file_get_contents($file->getRealPath());
                    $response = upload_image_api($fileContent, $fileName);

                    $result = json_decode($response, true);
                    $currentImages[] = $result['message'];
                }
            }

            // Menangani gambar yang dihapus setelah update berhasil
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    if (($key = array_search($deleteImage, $currentImages)) !== false) {
                        unset($currentImages[$key]);
                    }
                }
            }

            // Gabungkan nama file yang ada dan baru menjadi string
            $imgDescLocation = implode(',', $currentImages);

            $desc = [
                'description' => $request->description,
                'img_desc_location' => $imgDescLocation,
                'patrol_area_id' => $patrolAreaId,
                'created_at' => $patrolAreaDesc->created_at,
                'updated_at' => now(),
            ];
            
            $patrolAreaDesc->update($desc);
            DB::commit();

            insert_audit_log('Automated update data patrol area description after update patrol area');
            return redirect()->route('patrol-area.index')->with('success', 'Patrol Area berhasil diubah');
        } catch(Exception $e) {
            DB::rollback();
            Log::error('PatrolAreaController update_desc() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Deskripsi Patrol Area gagal diubah: ' . $e->getMessage());
        }
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

            $patrolArea = PatrolArea::find($id);
            $patrolAreaDesc = PatrolAreaDescription::where('patrol_area_id', $patrolArea->id)->first();

            // Hapus gambar thumbnail patrol area dari server jika ada
            // if ($patrolArea->img_location) {
            //     $image = $patrolArea->img_location;
            //     if (file_exists(public_path('gambar/patrol-area/' . $image))) {
            //         unlink(public_path('gambar/patrol-area/' . $image));
            //     }
            // }

            // Hapus gambar deskripsi patrol area dari server jika ada
            // if ($patrolAreaDesc->img_desc_location) {
            //     $images = explode(',', $patrolAreaDesc->img_desc_location);
            //     foreach ($images as $image) {
            //         if (file_exists(public_path('gambar/patrol-area/' . $image))) {
            //             unlink(public_path('gambar/patrol-area/' . $image));
            //         }
            //     }
            // }

            // Hapus data patrol area desc dan patrol area
            $patrolAreaDesc->delete();
            $patrolArea->delete();
            DB::commit();

            insert_audit_log('Delete data patrol area');
            insert_audit_log('Delete data patrol area description after patrol area was deleted');
            redis_reset_api('patrolarea');
            return redirect()->route('patrol-area.index')->with('success', 'Patrol Area berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('PatrolAreaController destroy() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Patrol Area gagal dihapus: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = PatrolArea::with(['area'], function($query){
            $query->select('id', 'name');
        });

        if(auth()->user()->hasRole('admin-area')){
            $area_id = explode(',' ,auth()->user()->access_area);

            $data->whereHas('area', function ($query) use ($area_id) {
                $query->whereIn('area_id', $area_id);
            });
        }
        
        $row = $data->get();
        return DataTables::of($row)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('code', '{{$code}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('image', function ($row) {
                $images = $row->img_location;
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
            ->rawColumns(['image'])
            ->addColumn('coordinat', '{{$location_long_lat ? $location_long_lat : "-"}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('area', '{{$area["name"]}}')
            ->addColumn('action', function (PatrolArea $data) {
                return [
                    'showurl' => route('patrol-area.show', $data->id),
                    'editurl' => route('patrol-area.edit', $data->id),
                    'deleteurl' => route('patrol-area.destroy', $data->id)
                ];
            })
        ->toJson();
    }

    public function by_area(Request $request, $id)
    {
        try {
            $old = [];
            if ($id != 0) {
                $old = $request->area_id;
                $data = PatrolArea::where('area_id', $id)->get();
            } else {
                if (auth()->user()->hasRole('admin-area')) {
                    $area_id = explode(',', auth()->user()->access_area);
                
                    $data = PatrolArea::whereIn('area_id', $area_id)->get();
                }  else {
                    $data = PatrolArea::all();
                }
            }

            if ($data->count() <= 0) {
                return response()->json([
                    "status" => "false",
                    "messege" => "gagal mengambil data patrol area",
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
                "messege" => "berhasil mengambil data patrol area",
                "data" => [$html]
            ], 200);
        } catch (Throwable $th) {
            Log::debug($th->getMessage());
        }
    }
}
