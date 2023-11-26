<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\ProjectModel;
use App\Models\Wilayah;
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
        return view('super-admin.project.create', $data);
    }

    // done
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'namaProyek' => 'required|string|max:255', // Tambahkan aturan validasi yang diperlukan
                'idWilayah' => 'required|numeric', // Tambahkan aturan validasi yang diperlukan
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();

            // Sesuaikan nama field dengan skema tabel Anda
            ProjectModel::create([
                'nama_project' => $data['namaProyek'],
                'wilayah' => $data['idWilayah'],
            ]);

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
        $data['title'] = 'Detail Project Model';
        $data['project_model'] = ProjectModel::find($id);
        return view('super-admin.project.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Project Model';
        $data['project_model'] = ProjectModel::find($id);
        // dd($data['project_model']);
        return view('super-admin.project.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'namaProyek' => 'required|string|max:255', // Sesuaikan aturan validasi
                'namaWilayah' => 'required|integer', // Sesuaikan aturan validasi
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $project = ProjectModel::find($id);
            if (!$project) {
                return redirect()->back()->with('error', 'Project tidak ditemukan');
            }

            // Update data project
            $project->update([
                'nama_project' => $request->namaProyek,
                'wilayah' => $request->namaWilayah,
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

        $data = ProjectModel::with('data_wilayah')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('nama_project', '{{$nama_project}}')
            ->addColumn('wilayah', '{{$data["data_wilayah"]["nama"]}}')
            ->addColumn('created_at', function($data){
                $createdAt = Carbon::parse($data->created_at);
                return $createdAt->format('m/d/Y H:i:s');
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
            <span>' . $item->nama_project . '</span>
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
