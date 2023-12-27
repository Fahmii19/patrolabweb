<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Area;
use App\Models\PatrolArea;
use App\Models\PatrolAreaDescription;
use App\Models\Wilayah;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use JsonIncrementalParser;
use Mockery\Expectation;

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
        $data['area'] = Area::all(); // Data area untuk admin-area
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
                'img_location' => 'nullable|image|mimes:jpeg,png,jpg',
                'area_id' => 'required|numeric',
                'description' => 'nullable|string',
                'img_desc_location.*' => 'nullable|image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            // Menangani upload thumbnail patrol area
            $imgLocation = null;
            if ($request->hasFile('img_location')) {
                $file = $request->file('img_location');
                $currentDateTime = date('Ymd_His');
                $imgLocation = $currentDateTime . '_' . $file->getClientOriginalName();    
                $file->move(public_path('gambar/patrol-area'), $imgLocation);
            }

            $validated = $validator->validated();

            $data = [
                'code' => $validated['code'],
                'name' => $validated['name'],
                'location_long_lat' => $validated['location_long_lat'],
                'img_location' => $imgLocation,
                'status' => 'ACTIVED',
                'area_id' => $validated['area_id'],
                'created_at' => now(),
                'updated_at' => null,
            ];

            $patrolAreaId = PatrolArea::insertGetId($data);
            DB::commit();
            
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
                    $currentDateTime = date('Ymd_His');
                    $filename = $currentDateTime . '_' . $file->getClientOriginalName();
                    $file->move(public_path('gambar/patrol-area'), $filename);
                    $filenames[] = $filename;
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

        return response()->json($data);
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
        $data['area'] = Area::all();
        $data['patrol_area'] = PatrolArea::find($id);

        if (!$data['patrol_area']) {
            return redirect()->back()->with('error', 'Patrol Area tidak ditemukan.');
        }

        $data['patrol_area_desc'] = PatrolAreaDescription::where('patrol_area_id', $data['patrol_area']->id)->first();

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
            $imgLocation = $patrolArea->img_location;
            if ($request->hasFile('img_location')) {
                $file = $request->file('img_location');
                $currentDateTime = date('Ymd_His');
                $imgLocation = $currentDateTime . '_' . $file->getClientOriginalName();    
                $file->move(public_path('gambar/patrol-area'), $imgLocation);

                // Hapus gambar lama jika ada
                if ($patrolArea->img_location && file_exists(public_path('gambar/patrol-area/' . $patrolArea->img_location))) {
                    unlink(public_path('gambar/patrol-area/' . $patrolArea->img_location));
                }
            }

            $validated = $validator->validated();

            $data = [
                'code' => $validated['code'],
                'name' => $validated['name'],
                'location_long_lat' => $validated['location_long_lat'],
                'img_location' => $imgLocation,
                'status' => $validated['status'] ?? 'INACTIVED',
                'area_id' => $validated['area_id'],
                'created_at' => $patrolArea->created_at,
                'updated_at' => now(),
            ];

            $patrolArea->update($data);
            DB::commit();
            
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
                    $currentDateTime = date('Ymd_His');
                    $filename = $currentDateTime . '_' . $file->getClientOriginalName();
                    $file->move(public_path('gambar/patrol-area'), $filename);
                    $currentImages[] = $filename;
                }
            }

            // Menangani gambar yang dihapus setelah update berhasil
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    if (($key = array_search($deleteImage, $currentImages)) !== false) {
                        // Hapus file dari server
                        if (file_exists(public_path('gambar/area/' . $deleteImage))) {
                            unlink(public_path('gambar/area/' . $deleteImage));
                        }
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
            if ($patrolArea->img_location) {
                $image = $patrolArea->img_location;
                if (file_exists(public_path('gambar/patrol-area/' . $image))) {
                    unlink(public_path('gambar/patrol-area/' . $image));
                }
            }

            // Hapus gambar deskripsi patrol area dari server jika ada
            if ($patrolAreaDesc->img_desc_location) {
                $images = explode(',', $patrolAreaDesc->img_desc_location);
                foreach ($images as $image) {
                    if (file_exists(public_path('gambar/patrol-area/' . $image))) {
                        unlink(public_path('gambar/patrol-area/' . $image));
                    }
                }
            }

            // Hapus data patrol area desc dan patrol area
            $patrolAreaDesc->delete();
            $patrolArea->delete();
            DB::commit();

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
        })->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('code', '{{$code}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('image', function ($row) {
                $imgHtml = '';
                // Cek jika file gambar ada
                if ($row->img_location && file_exists(public_path('gambar/patrol-area/' . $row->img_location))) {
                    $url = asset('gambar/patrol-area/' . $row->img_location);
                } else {
                    // Jika tidak ada, gunakan gambar default
                    $url = asset('gambar/no-image.png'); // Pastikan gambar no-image.png tersedia di folder public/gambar
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
            if ($request->id_project) {
                $old = $request->id_project;
            }

            $data = PatrolArea::where('area_id', $id)->get();
            if ($data->count() <= 0) {
                return response()->json([
                    "status" => "false",
                    "messege" => "gagal mengambil data patrol area",
                    "data" => []
                ], 404);
            }
            $html = '<option value="" selected disabled>--Pilih--</option>';
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
