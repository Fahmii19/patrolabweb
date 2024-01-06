<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Project;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Daftar Project';
        $data['project_model'] = Project::all();
        return view('super-admin.project.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Tambah Project';
        $data['wilayah'] = Wilayah::where('province_id', 1)->get(); // Provinsi default sementara
        $data['branches'] = Branch::all();
        return view('super-admin.project.create', $data);
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
                'code' => 'required|string|unique:projects',
                'name' => 'required|string',
                'address' => 'required|string',
                'location_long_lat' => 'required|string',
                'branch_id' => 'required|numeric',
                'city_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $data = $validator->validated();
            $data['status'] = "ACTIVED";
            $data['created_at'] = now();
            $data['updated_at'] = null;

            Project::create($data);
            DB::commit();

            insert_audit_log('Insert data project');
            return redirect()->route('project.index')->with('success', 'Proyek berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('ProjectController store() -' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi Kesalahan: ' . $e->getMessage());
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
        $data['title'] = 'Detail Project Model';
        $data['project'] = Project::with('wilayah', 'branch')->findOrFail($id);
        return view('super-admin.project.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Project Model';
        $data['wilayah'] = Wilayah::all();
        $data['branchs'] = Branch::all();
        $data['project'] = Project::find($id);

        return view('super-admin.project.edit', $data);
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
        try {
            DB::beginTransaction();

            // Updated validation rules to match form field names
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|max:255|unique:projects,code,'. $id,
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'location_long_lat' => 'string|string',
                'city_id' => 'required|integer',
                'branch_id' => 'required|integer',
                'status' => 'nullable|string|in:ACTIVED,INACTIVED',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $project = Project::find($id);
            if (!$project) {
                return redirect()->back()->with('error', 'Project tidak ditemukan');
            }

            // Update project data
            $data = $validator->validated();
            $data['status'] = $data['status'] ?? 'INACTIVED';
            $data['created_at'] = $project->created_at;
            $data['updated_at'] = now();

            $project->update($data);
            DB::commit();

            insert_audit_log('Update data project');
            return redirect()->route('project.index')->with('success', 'Proyek berhasil diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ProjectController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
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

            Project::find($id)->delete();
            DB::commit();

            insert_audit_log('Delete data project');
            return redirect()->route('project.index')->with('success', 'Proyek berhasil dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ProjectController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Project::with('wilayah', 'branch')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns([])
            ->addColumn('code', '{{$code}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('region', '{{$wilayah["name"]}}')
            ->addColumn('branch', '{{$branch["name"]}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('created_at', function ($data) {
                return date('m/d/Y H:i:s', strtotime($data->created_at));
            })
            ->addColumn('action', function (Project $project) {
                return [
                    'editurl' => route('project.edit', $project->id),
                    'deleteurl' => route('project.destroy', $project->id),
                    'detailurl' => route('project.show', $project->id)
                ];
            })
            ->toJson();
    }


    public function by_wilayah_checkbox(Request $request, $id)
    {
        $old = [];
        if ($request->id_project) {
            $old = explode(',', $request->id_project);
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
            $checked = in_array($item->id, $old) ? 'checked' : '';
            $html .= '<label class="col">
            <input class="form-check-input me-1" type="checkbox" value="' . $item->id . '"
                name="id_project[]" ' . $checked . '>
            <span>' . $item->name . '</span>
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
                $html .= '<option value="' . $item->id . '"' . $selected . '>' . $item->name . '</option>';
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
