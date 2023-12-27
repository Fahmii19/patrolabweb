<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Branch;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Branch";
        return view('super-admin.branch.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Branch";
        return view('super-admin.branch.create', $data);
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
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|unique:branch',
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data['status'] = 'ACTIVED';

            Branch::create($data);
            DB::commit();

            return redirect()->route('branch.index')->with('success', 'Branch berhasil ditambahhkan');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('BranchController store() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Branch gagal ditambahkan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        // return dd($branch->project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        //
        $data['title'] = "Edit Data Branch";
        $data['branch'] = $branch;

        if (!$data['branch']) {
            return redirect()->back()->with('error', 'Branch tidak ditemukan.');
        }

        return view('super-admin.branch.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $area
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Branch $branch)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|unique:branch,code,' . $branch->id,
                'name' => 'required|string',
                'status' => 'nullable|string|in:ACTIVED,INACTIVED',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data['status'] = $data['status'] ?? 'INACTIVED';

            // Update data branch
            $branch->update($data);
            DB::commit();

            return redirect()->route('branch.index')->with('success', 'Branch berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('BranchController update() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Branch gagal diperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        try {
            DB::beginTransaction();

            if ($branch->delete()) {
                DB::commit();
                return redirect()->route('branch.index')->with('success', 'Branch berhasil dihapus');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'Branch gagal dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('BranchController destroy() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Branch gagal dihapus: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Branch::get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->escapeColumns('active')
        ->addColumn('code', '{{$code}}')
        ->addColumn('name', '{{$name}}')
        ->addColumn('status', '{{$status}}')
        ->addColumn('action', function (Branch $branch) {
            $data = [
                'editurl' => route('branch.edit', $branch->id),
                'deleteurl' => route('branch.destroy', $branch->id)
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
        $data = Project::find($id)->areas;
        if ($data->count() <= 0) {
            return response()->json([
                "status" => "false",
                "message" => "gagal mengambil data Branch",
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
            "message" => "berhasil mengambil data Branch",
            "data" => [$html]
        ], 200);
    }
}
