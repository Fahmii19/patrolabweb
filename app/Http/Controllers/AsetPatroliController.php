<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AsetPatroli;
use Throwable;

class AsetPatroliController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Aset Patroli';
        //$data['aset_patroli'] = AsetPatroli::all();
        return view('super-admin.aset-patroli.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Aset Patroli';
        return view('super-admin.aset-patroli.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'kode' => 'required',
                'id_aset' => 'required',
                'id_wilayah' => 'required',
                'id_area' => 'required',
                'tanggal_penyerahan' => 'required',
                'foto' => 'required',
                'jumlah' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            AsetPatroli::create($data);
            DB::commit();
            return redirect()->route('aset-patroli.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AsetPatroliController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Aset Patroli';
        $data['aset_patroli'] = AsetPatroli::find($id);
        return view('super-admin.aset-patroli.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Aset Patroli';
        $data['aset_patroli'] = AsetPatroli::find($id);
        return view('super-admin.aset-patroli.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'kode' => 'required',
                'id_aset' => 'required',
                'id_wilayah' => 'required',
                'id_area' => 'required',
                'tanggal_penyerahan' => 'required',
                'foto' => 'required',
                'jumlah' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            AsetPatroli::find($id)->update($data);
            DB::commit();
            return redirect()->route('aset-patroli.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AsetPatroliController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            AsetPatroli::find($id)->delete();
            DB::commit();
            return redirect()->route('aset-patroli.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AsetPatroliController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
