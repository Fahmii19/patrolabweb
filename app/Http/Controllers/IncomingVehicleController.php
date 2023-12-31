<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Models\IncomingVehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class IncomingVehicleController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Kendaraan Masuk';
        // $data['incoming_vehicle'] = IncomingVehicle::all();
        return view('super-admin.incoming_vehicle.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Kendaraan Masuk';
        return view('super-admin.incoming_vehicle.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'rfid_masuk' => 'required',
                'plat' => 'required',
                'pemilik_kartu' => 'required',
                'status' => 'required',
                'tanggal_masuk' => 'required',
                'foto_keluar' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            IncomingVehicle::create($data);
            DB::commit();
            return redirect()->route('incoming-vehicle.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('IncomingVehicleController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Incoming Vehicle';
        $data['incoming_vehicle'] = IncomingVehicle::find($id);
        return view('super-admin.incoming_vehicle.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Incoming Vehicle';
        $data['incoming_vehicle'] = IncomingVehicle::find($id);
        return view('super-admin.incoming_vehicle.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'rfid_masuk' => 'required',
                'plat' => 'required',
                'pemilik_kartu' => 'required',
                'status' => 'required',
                'tanggal_masuk' => 'required',
                'foto_keluar' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            IncomingVehicle::find($id)->update($data);
            DB::commit();
            return redirect()->route('incoming-vehicle.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('IncomingVehicleController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            IncomingVehicle::find($id)->delete();
            DB::commit();
            return redirect()->route('incoming-vehicle.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('IncomingVehicleController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = IncomingVehicle::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('no_kartu', '{{$no_kartu}}')
            ->addColumn('plat', '{{$plat}}')
            ->addColumn('pemilik', '{{$pemilik_kartu}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('tanggal_masuk', '{{$tanggal_masuk}}')
            ->addColumn('foto_masuk', '{{$foto_masuk}}')
            ->toJson();
    }

}
