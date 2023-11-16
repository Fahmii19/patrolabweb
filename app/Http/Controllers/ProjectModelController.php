<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\ProjectModel;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectModelController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Project';
        $data['project_model'] = ProjectModel::all();
        return view('super-admin.project.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Project';
        return view('super-admin.project.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'nama_project' => 'required',
                'wilayah' => 'required|in:option1',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            ProjectModel::create($data);
            DB::commit();
            return redirect()->route('project-model.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ProjectModelController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        //return dd(ProjectModel::find($id)->data_wilayah);
        $data['title'] = 'Detail Project Model';
        $data['project_model'] = ProjectModel::find($id);
        return view('super-admin.project.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Project Model';
        $data['project_model'] = ProjectModel::find($id);
        return view('super-admin.project.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'nama_project' => 'required',
                'wilayah' => 'required|in:option1',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            ProjectModel::find($id)->update($data);
            DB::commit();
            return redirect()->route('project-model.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ProjectModelController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            ProjectModel::find($id)->delete();
            DB::commit();
            return redirect()->route('project-model.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ProjectModelController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = ProjectModel::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('nama_project', '{{$name}}')
            ->addColumn('wilayah', function (ProjectModel $project) {
                return $project->data_wilayah->name;
                // dd($project);
            })
            ->addColumn('action', function (ProjectModel $project) {
                $data = [
                    'editurl' => route('project-model.edit', $project->id),
                    'deleteurl' => route('project-model.destroy', $project->id)
                ];
                return $data;
            })
            ->toJson();
    }

    public function by_wilayah(Request $request,$id)
    {
        $old = [];
        if($request->id_project){
            $old = explode(',',$request->id_project);
        }
        $data = Wilayah::find($id)->projects;
        if ($data->count() <= 0) {
            return response()->json([
                "status" => "false",
                "messege" => "gagal mengambil data project",
                "data" => []
            ], 404);
        }
        $html = '';
        foreach ($data as $item) {
            $checked = in_array($item->id,$old) ? 'checked' : '';
            $html .= '<label class="col">
            <input class="form-check-input me-1" type="checkbox" value="'.$item->id.'"
                name="id_project[]" '.$checked.'>
            <span>'.$item->nama_project.'</span>
        </label>';
        }
        return response()->json([
            "status" => "true",
            "messege" => "berhasil mengambil data project",
            "data" => [$html]
        ], 200);
    }


    public function by_wilayah_select(Request $request, $id)
    {
        try {
            $old = [];
            if ($request->id_project) {
                $old = $request->id_project;
            }
            $data = Wilayah::find($id)->projects;
            if ($data->count() <= 0) {
                return response()->json([
                    "status" => "false",
                    "messege" => "gagal mengambil data project",
                    "data" => []
                ], 404);
            }
            $html = '<option value="" selected disabled>--Pilih--</option>';
            foreach ($data as $item) {
                $selected = $item->id == $old ? 'selected' : '';
                $html .= '<option value="' . $item->id . '"' . $selected . '>' . $item->nama_project . '</option>';
            }
            return response()->json([
                "status" => "true",
                "messege" => "berhasil mengambil data project",
                "data" => [$html]
            ], 200);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
        }
    }
}