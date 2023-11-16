<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Area;
use App\Models\Round;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoundController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Round';
        $data['round'] = Round::all();
        return view('super-admin.round.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Round';
        $data['wilayah'] = Wilayah::all();
        $data['area'] = Area::all();
        return view('super-admin.round.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'rute' => 'required',
                'waktu_mulai' => 'required',
                'waktu_selesai' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            Round::create($data);
            DB::commit();
            return redirect()->route('round.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('RoundController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Round';
        $data['round'] = Round::find($id);
        return view('super-admin.round.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Round';
        $data['round'] = Round::find($id);
        return view('super-admin.round.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'rute' => 'required',
                'waktu_mulai' => 'required',
                'waktu_selesai' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            Round::find($id)->update($data);
            DB::commit();
            return redirect()->route('round.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('RoundController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Round::find($id)->delete();
            DB::commit();
            return redirect()->route('round.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('RoundController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
