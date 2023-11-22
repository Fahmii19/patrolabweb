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

            // Validasi input, termasuk file gambar
            $this->validate($request, [
                'code' => ['required', 'unique:areas'],
                'name' => ['required', 'string'],
                'img_location' => 'required|file|image|mimes:jpeg,png,jpg|max:6048', // Validasi file gambar
                'project_id' => ['required', 'numeric'],
                'asset_id' => ['required', 'numeric']
            ]);

            // Inisialisasi nama file
            $filename = null;


            // dd($request->all());


            if ($request->hasFile('img_location')) {
                $file = $request->file('img_location');
                $currentDateTime = date('Ymd_His');
                $filename = $currentDateTime . '_' . $file->getClientOriginalName();

                // Pindahkan file ke direktori publik
                $file->move(public_path('gambar'), $filename);
            }


            // Membuat data area dengan filename gambar
            $action = Area::create([
                'code' => $request->code,
                'name' => $request->name,
                'img_location' => $filename,
                'project_id' => $request->project_id,
                'asset_id' => $request->asset_id
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        //
    }

    public function datatable()
    {
        $data = Area::with(['project', 'asset'])->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('code', function ($row) {
                return $row->code;
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('img_location', function ($row) {
                if ($row->img_location && file_exists(public_path('gambar/' . $row->img_location))) {
                    $url = asset('gambar/' . $row->img_location);
                } else {
                    $url = asset('gambar/no-image.png');
                }
                return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
            })
            ->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->nama_project : '-';
            })
            ->addColumn('asset_name', function ($row) {
                return $row->asset ? $row->asset->kode : '-';
            })
            ->rawColumns(['img_location'])
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
