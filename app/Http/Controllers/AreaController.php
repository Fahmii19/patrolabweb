<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Area;
use App\Models\Aset;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Area Project";
        return view('super-admin.area.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Area";
        $data['project'] = ProjectModel::all();
        return view('super-admin.area.create', $data);
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
                'code' => 'required|string|unique:areas',
                'name' => 'required|string',
                'img_location' => 'image|mimes:jpeg,png,jpg',
                'project_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $filename = null;
            if ($request->hasFile('img_location')) {
                $file = $request->file('img_location');
                $filename = date('Ymd_His') . '_' . $file->getClientOriginalName();
                $file->move(public_path('gambar/area'), $filename);
            }

            $data = $validator->validated();
            $data['status'] = 'ACTIVED';
            $data['img_location'] = $filename;
            $data['created_at'] = now();
            $data['updated_at'] = null;

            Area::create($data);
            DB::commit();
            
            insert_audit_log('Insert data area');
            return redirect()->route('area.index')->with('success', 'Area berhasil disimpan');    
        } catch (Exception $e) {
            DB::rollback();
            Log::error('AreaController store() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Area gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        // return dd($area->project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
        $data['title'] = "Edit Data Area";
        $data['area'] = $area;
        $data['projects'] = ProjectModel::all();
        return view('super-admin.area.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Area $area)
    {
        try {
            DB::beginTransaction();
           
            $validator = Validator::make($request->all(), [
                'project_id' => 'required|numeric',
                'code' => 'required|string|unique:areas,code,'. $area->id,
                'name' => 'required|string',
                'status' => 'nullable|string|in:ACTIVED,INACTIVED',
                'img_location' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $imgLocation = $area->img_location;
            if ($request->hasFile('img_location')) {
                $file = $request->file('img_location');
                $filename = date('Ymd_His') . '_' . $file->getClientOriginalName();
                $file->move(public_path('gambar/area'), $filename); // Sesuaikan path sesuai kebutuhan

                // Hapus gambar lama jika ada
                if ($imgLocation && file_exists(public_path('gambar/area/' . $imgLocation))) {
                    unlink(public_path('gambar/area/' . $imgLocation));
                }

                // Menyimpan nama file gambar baru
                $imgLocation = $filename; 
            }

            $data = $validator->validated();
            $data['img_location'] = $imgLocation;
            $data['status'] = $data['status'] ?? 'INACTIVED';
            $data['created_at'] = $area->created_at;
            $data['updated_at'] = now();

            $area->update($data);
            DB::commit();

            insert_audit_log('Update data area');
            redis_reset_api('area/spesific/'.$area->id);
            return redirect()->route('area.index')->with('success', 'Area berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('AreaController update() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Area gagal diperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        try {
            DB::beginTransaction();

           // Hapus gambar dari server jika ada
           if ($area->img_location) {
                if (file_exists(public_path('gambar/area/' . $area->img_location))) {
                    unlink(public_path('gambar/area/' . $area->img_location));
                }
            }

            // Hapus data area
            $area->delete();
            DB::commit();

            insert_audit_log('Delete data area');
            redis_reset_api('area');
            return redirect()->route('area.index')->with('success', 'Area berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('AreaController destroy() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data area gagal dihapus: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Area::with(['project'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('code', '{{$code}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('patrol_area', function($data){
                $patrol_area = Area::find($data->id)->patrol_area;
                return $patrol_area->count();
            })
            ->addColumn('status', '{{$status}}')
            ->addColumn('project', '{{$project_id ? $project["name"] : "-"}}')
            ->addColumn('image', function ($row) {
                $images = $row->img_location; 
                $imgHtml = '';

                if ($images && file_exists(public_path('gambar/area/' . $images))) {
                    $url = asset('gambar/area/' . $images);
                } else {
                    $url = asset('gambar/no-image.png'); // Gambar default
                }
                $imgHtml .= '<span class="btn" data-bs-toggle="modal" data-bs-target="#imageModal' . $row->id . '"><img src="' . $url . '" border="0" width="100" class="img-rounded mr-1" align="center" /></span>';

                // Modal untuk setiap gambar
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
            ->addColumn('action', function (Area $area) {
                $data = [
                    'editurl' => route('area.edit', $area->id),
                    'deleteurl' => route('area.destroy', $area->id)
                ];
                return $data;
            })

            ->toJson();
    }


    public function by_project(Request $request, $id)
    {
        $old = [];
        if ($request->id_area) {
            $old = $request->id_area;
        }
        $data = ProjectModel::find($id)->areas;
        if ($data->count() <= 0) {
            return response()->json([
                "status" => "false",
                "messege" => "gagal mengambil data Area",
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
            "messege" => "berhasil mengambil data Area",
            "data" => [$html]
        ], 200);
    }
}
