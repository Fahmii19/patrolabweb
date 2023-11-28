<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Branch;
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
            // $validatedData = $request->validate([
            //     'code' => ['required', 'unique:branches,code'],
            //     'name' => ['required', 'string'],
            //     'status' => ['required', 'string'],
            // ]);

            // Membuat data branch
            Branch::create([
                'code' => $request->code,
                'name' => $request->name,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('branch.index')->with('success', 'Data branch berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('BranchController store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data branch gagal disimpan: ' . $e->getMessage());
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
            // $validatedData = $request->validate([
            //     'code' => ['required', 'unique:branches,code,' . $branch->id],
            //     'name' => ['required', 'string'],
            //     // Tambahkan validasi untuk status jika diperlukan
            //     'status' => ['required', 'string'],
            //     // Hapus atau sesuaikan validasi gambar dan project ID
            // ]);

            // Hapus atau sesuaikan logika untuk menangani gambar dan project ID

            // Update data branch
            $branch->update([
                'code' => $request->code,
                'name' => $request->name,
                'status' => $request->status // Menyimpan status
                // Hapus atau sesuaikan atribut lain
            ]);

            DB::commit();
            return redirect()->route('branch.index')->with('success', 'Data branch berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('BranchController update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data branch gagal diperbarui: ' . $e->getMessage());
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
        // hapus data
        $branch->delete();
        return redirect()->route('branch.index')->with('success', 'Data Branch berhasil dihapus');
    }

    public function datatable()
    {
        $data = Branch::get();

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
        $data = ProjectModel::find($id)->areas;
        if ($data->count() <= 0) {
            return response()->json([
                "status" => "false",
                "messege" => "gagal mengambil data Branch",
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
            "messege" => "berhasil mengambil data Branch",
            "data" => [$html]
        ], 200);
    }
}
