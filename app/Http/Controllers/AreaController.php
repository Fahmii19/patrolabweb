<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Area;
use App\Models\Aset;
use App\Models\ProjectModel;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

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
        $data['asset'] = Aset::all();
        // dd($data['asset']);
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

            // Validasi input
            // $validatedData = $request->validate([
            //     'code' => ['required', 'unique:areas,code'],
            //     'name' => ['required', 'string'],
            //     'img_location' => 'required',
            //     'project_id' => ['required', 'numeric'],
            // ]);

            $filenames = [];

            // Menangani upload gambar
            if ($request->hasFile('img_location')) {
                foreach ($request->file('img_location') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('gambar/area'), $filename);
                    $filenames[] = $filename;
                }
            }

            // Gabungkan nama file menjadi string jika ada lebih dari satu gambar
            $imgLocation = implode(',', $filenames);

            // Membuat data area
            Area::create([
                'code' => $request->code,
                'name' => $request->name,
                'img_location' => $imgLocation,
                'project_id' => $request->project_id,
                'status' => $request->status // Menyimpan status
            ]);

            DB::commit();
            return redirect()->route('area.index')->with('success', 'Data area berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('AreaController store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data area gagal disimpan: ' . $e->getMessage());
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
        $data['asset'] = Aset::all();
        // dd($data);
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

            // Validasi input
            // $validatedData = $request->validate([
            //     'code' => ['required', 'unique:areas,code,' . $area->id],
            //     'name' => ['required', 'string'],
            //     'img_location.*' => 'file|image|mimes:jpeg,png,jpg|max:6048', // Validasi untuk setiap file gambar
            //     'project_id' => ['required', 'numeric'],
            //     // Tambahkan validasi untuk status jika diperlukan
            // ]);

            $currentImages = explode(',', $area->img_location);
            $filenames = [];

            // Menangani gambar yang dihapus
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

            // Menangani upload gambar baru
            if ($request->hasFile('img_location')) {
                foreach ($request->file('img_location') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('gambar/area'), $filename);
                    $currentImages[] = $filename;
                }
            }

            // Gabungkan nama file yang ada dan baru menjadi string
            $imgLocation = implode(',', $currentImages);

            // Update data area
            $area->update([
                'code' => $request->code,
                'name' => $request->name,
                'img_location' => $imgLocation,
                'project_id' => $request->project_id,
                'status' => $request->status // Menyimpan status
            ]);

            DB::commit();
            return redirect()->route('area.index')->with('success', 'Data area berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('AreaController update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data area gagal diperbarui: ' . $e->getMessage());
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
                $images = explode(',', $area->img_location);
                foreach ($images as $image) {
                    if (file_exists(public_path('gambar/area/' . $image))) {
                        unlink(public_path('gambar/area/' . $image));
                    }
                }
            }

            // Hapus data area
            $area->delete();

            DB::commit();
            return redirect()->route('area.index')->with('success', 'Data area berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('AreaController destroy error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data area gagal dihapus: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Area::with(['project'])->get();

        // dd($data);

        // foreach ($data as $item) {
        //     dd($item->img_location);
        // }

        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('code', function ($row) {
                return $row->code;
            })

            ->addColumn('name', function ($row) {
                return $row->name;
            })

            ->addColumn('status', function ($row) {
                return $row->status == 'ACTIVED' ? 'Aktif' : 'Tidak Aktif';
            })

            ->addColumn('project', function ($row) {
                return $row->project ? $row->project->nama_project : '-';
            })

            ->addColumn('image', function ($row) {
                $images = explode(',', $row->img_location); // Misalnya jika img_location adalah string nama file yang dipisah dengan koma
                $imgHtml = '';

                foreach ($images as $index => $image) {
                    if ($image && file_exists(public_path('gambar/area/' . $image))) {
                        $url = asset('gambar/area/' . $image);
                    } else {
                        $url = asset('gambar/no-image.png'); // Gambar default
                    }
                    $imgHtml .= '<a href="#!" data-toggle="modal" data-target="#imageModal' . $row->id . '_' . $index . '"><img src="' . $url . '" border="0" width="50" class="img-rounded mr-1" align="center" /></a>';

                    // Modal untuk setiap gambar
                    $imgHtml .= '
            <div class="modal fade" id="imageModal' . $row->id . '_' . $index . '" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="' . $url . '" class="img-fluid">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
                }

                return $imgHtml;
            })
            ->rawColumns(['image'])


            // ->addColumn('image', function ($row) {
            //     if ($row->img_location && file_exists(public_path('gambar/area/' . $row->img_location))) {
            //         // dd($row->img_location);
            //         $url = asset('gambar/area/' . $row->img_location);
            //     } else {
            //         // Jika tidak ada, gunakan gambar default
            //         $url = asset('gambar/no-image.png'); // Pastikan gambar no-image.png tersedia di folder public/gambar
            //     }
            //     return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
            // })
            // ->rawColumns(['image'])

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
            $html .= '<option value="' . $item->id . '"' . $selected . '>' . $item->nama . '</option>';
        }
        return response()->json([
            "status" => "true",
            "messege" => "berhasil mengambil data Area",
            "data" => [$html]
        ], 200);
    }
}
