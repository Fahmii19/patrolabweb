<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\ProjectModel;
use App\Models\Wilayah;
use App\Models\Branch;
use Carbon\Carbon;
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
        $data['wilayah'] = Wilayah::all();
        $data['branches'] = Branch::all();
        return view('super-admin.project.create', $data);
    }

    // done
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi data input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'wilayah_id' => 'required|numeric',
                'branch_id' => 'required|numeric',
                'address' => 'required|string',
                'location_long_lat' => 'required|string',
                'status' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            // Data yang telah divalidasi
            $data = $validator->validated();

            // Membuat record baru di database
            ProjectModel::create([
                'name' => $data['name'],
                'code' => $data['code'],
                'wilayah_id' => $data['wilayah_id'],
                'branch_id' => $data['branch_id'],
                'address' => $data['address'],
                'location_long_lat' => $data['location_long_lat'],
                'status' => $data['status'],
            ]);

            DB::commit();
            return redirect()->route('project-model.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('ProjectModelController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi Kesalahan: ' . $e->getMessage());
        }
    }



    public function show($id)
    {
        $data['title'] = 'Detail Project Model';
        $data['project_model'] = ProjectModel::with('data_wilayah', 'data_branch')->findOrFail($id);
        return view('super-admin.project.show', $data);
    }


    public function edit($id)
    {
        $data['title'] = 'Edit Project Model';
        $data['project_model'] = ProjectModel::find($id);
        $data['wilayah'] = Wilayah::all();
        $data['branches'] = Branch::all();

        return view('super-admin.project.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Updated validation rules to match form field names
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'wilayah_id' => 'required|integer',
                'branch_id' => 'required|integer',
                'address' => 'required|string|max:255',
                'location_long_lat' => 'nullable|string',
                'status' => 'required|string|in:ACTIVED,INACTIVED',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $project = ProjectModel::find($id);
            if (!$project) {
                return redirect()->back()->with('error', 'Project tidak ditemukan');
            }

            // Update project data
            $project->update([
                'name' => $request->name,
                'code' => $request->code,
                'wilayah_id' => $request->wilayah_id,
                'branch_id' => $request->branch_id,
                'address' => $request->address,
                'location_long_lat' => $request->location_long_lat,
                'status' => $request->status,
            ]);

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
        $data = ProjectModel::with('data_wilayah', 'data_branch')->get();
        // dd($data);

        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns([])
            ->addColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('wilayah', function ($row) {
                return $row->data_wilayah ? $row->data_wilayah->nama : '-';
            })
            ->addColumn('branch', function ($row) {
                return $row->data_branch ? $row->data_branch->name : '-';
            })

            ->addColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('m/d/Y H:i:s');
            })

            ->addColumn('action', function (ProjectModel $project) {
                return [
                    'editurl' => route('project-model.edit', $project->id),
                    'deleteurl' => route('project-model.destroy', $project->id),
                    'detailurl' => route('project-model.show', $project->id)
                ];
            })
            ->rawColumns(['name'])
            ->toJson();
    }


    public function by_wilayah(Request $request, $id)
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
