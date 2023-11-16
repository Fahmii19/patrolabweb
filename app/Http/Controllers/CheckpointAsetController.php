<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Models\CheckpointAset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CheckpointAsetController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Checkpoint Aset';
        $data['checkpoint_aset'] = CheckpointAset::all();
        return view('super-admin.checkpoint-aset.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Checkpoint Aset';
        return view('super-admin.checkpoint-aset.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'indikator' => 'required',
                'jumlah' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            CheckpointAset::create($data);
            DB::commit();
            return redirect()->route('checkpoint-aset.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckpointAsetController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Checkpoint Aset';
        $data['checkpoint_aset'] = CheckpointAset::find($id);
        return view('super-admin.checkpoint-aset.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Checkpoint Aset';
        $data['checkpoint_aset'] = CheckpointAset::find($id);
        return view('super-admin.checkpoint-aset.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'indikator' => 'required',
                'jumlah' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            CheckpointAset::find($id)->update($data);
            DB::commit();
            return redirect()->route('checkpoint-aset.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckpointAsetController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            CheckpointAset::find($id)->delete();
            DB::commit();
            return redirect()->route('checkpoint-aset.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('CheckpointAsetController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = CheckpointAset::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('id_check_point', function (CheckpointAset $cpas) {
                return $cpas->cpa->nama;
            })
            ->addColumn('nama', '{{$nama}}')
            ->addColumn('indikator', '{{$indikator}}')
            ->addColumn('jumlah', '{{$jumlah}}')
            ->addColumn('foto', '{{$foto}}')
            ->toJson();
    }
}
