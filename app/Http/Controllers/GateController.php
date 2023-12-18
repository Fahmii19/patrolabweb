<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Gate;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class GateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Daftar Gate';
        $data['project_model'] = Gate::all();
        return view('super-admin.gate.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Gate";
        $data['wilayah'] = Wilayah::all();
        return view('super-admin.gate.create', $data);
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
                'project_id' => 'required|numeric',
                'code' => 'required|string|unique:gate',
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $data = $validator->validated();
            $data['status'] = "ACTIVED";
            $data['created_at'] = now();

            if (Gate::create($data)) {
                DB::commit();
                return redirect()->route('gate.index')->with('success', 'Gate berhasil ditambahkan');
            }

            DB::rollback();
            return redirect()->route('gate.index')->with('success', 'Gate gagal ditambahkan');
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error('GateController store() -' . $e->getMessage());
            return redirect()->back()->with('error' . $e->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = "Edit Gate";
        $data['gate'] = Gate::with(['project' => function($query) {
            $query->select('id', 'name', 'city_id');
            $query->with(['wilayah' => function($query) {
                $query->select('id', 'name');
            }]);
        }])->find($id);
        $data['wilayah'] = Wilayah::all();

        // Pastikan gate ditemukan sebelum mencoba mengakses metode pada objeknya
        if (!$data['gate']) {
            // Handle kasus di mana gate tidak ditemukan, misalnya tampilkan pesan error atau redirect
            return redirect()->back()->with('error', 'Gate tidak ditemukan.');
        }

        $data['project'] = Wilayah::find($data['gate']->project->wilayah->id)->projects;
        // return response()->json($data);
        return view('super-admin.gate.edit', $data);
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
            $validator = Validator::make($request->all(), [
                'project_id' => 'required|numeric',
                'code' => 'required|string|unique:gate,code,' . $id,
                'name' => 'required|string',
                'status' => 'nullable|string|in:ACTIVED,INACTIVED',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $gate = Gate::find($id);
            if (!$gate) {
                throw new Exception('User tidak ditemukan.');
            }

            $data = $validator->validated();
            $data['status'] = $data['status'] ?? 'INACTIVED';

            $gate->update($data);

            DB::commit();
            return redirect()->route('gate.index')->with('success', 'Gate berhasil diperbarui');
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('GateController update() -' . $e->getMessage());
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
            $gate = Gate::find($id);
            DB::beginTransaction();

            if ($gate->delete()) {
                DB::commit();
                return redirect()->route('gate.index')->with('success', 'Gate berhasil dihapus');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'Gate gagal dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('GateController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function datatable()
    {
        $data = Gate::with(['project.wilayah'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('code', '{{$code}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('project', '{{$project["name"]}}')
            ->addColumn('wilayah', '{{$project["wilayah"]["name"]}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('action', function (Gate $gate) {
                $data = [
                    'editurl' => route('gate.edit', $gate->id),
                    'deleteurl' => route('gate.destroy', $gate->id)
                ];
                return $data;
            })
            ->toJson();
    }
}
