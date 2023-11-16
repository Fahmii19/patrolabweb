<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Area;
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
            // $data = $request->validate([
            //     'kode' => ['required', 'unique:areas'],
            //     'nama' => ['required', 'string'],
            //     'id_wilayah' => ['required', 'numeric']
            // ]);
            $validator = Validator::make($request->all(),
                [
                    'code' => ['required', 'unique:areas'],
                    'name' => ['required', 'string'],
                    'img_location' => ['required', 'string'],
                    'project_id' => ['required', 'numeric']
                ]
                );

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
                }
                
            $data = $validator->validated();
            $action = Area::create($data);
            DB::commit();

            if ($action) {
                return redirect()->route('area.index')->with('success', 'data area berhasil disimpan');
            }
            DB::rollback();
            return redirect()->back()->with('error', 'data arae gagal disimpan');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('AreaController store ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
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
        $data = Area::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('code', '{{$code}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('img_location', '{{$img_location}}')
            ->addColumn('project_id', function(Area $area){
                return $area->project->name;
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
            $html .= '<option value="'.$item->id.'"'.$selected.'>'.$item->nama.'</option>';
        }
        return response()->json([
            "status" => "true",
            "messege" => "berhasil mengambil data Area",
            "data" => [$html]
        ], 200);
    }
}
