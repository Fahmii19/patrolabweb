<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Wilayah;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Wilayah";
        return view('super-admin.wilayah.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Wilayah";
        $data['province'] = Province::all();
        return view('super-admin.wilayah.create', $data);
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
                'province_id' => 'required|numeric',
                'name' => 'required|string|unique:city',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            Wilayah::create($data);
            DB::commit();

            return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('WilayahController store() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wilayah  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function show(Wilayah $wilayah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wilayah  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function edit(Wilayah $wilayah)
    {
        $data['title'] = "Edit Data Wilayah";
        $data['province'] = Province::all();
        $data['wilayah'] = $wilayah;
        
        if (!$data['wilayah']) {
            return redirect()->back()->with('error', 'Wilayah tidak ditemukan.');
        }

        return view('super-admin.wilayah.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wilayah  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wilayah $wilayah)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'province_id' => 'required|numeric',
                'name' => 'required|string|unique:city,name,' . $wilayah->id,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();

            $wilayah->update($data);
            DB::commit();

            return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('WilayahController update() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wilayah  $wilayah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wilayah $wilayah)
    {
        try {
            if (!$wilayah) {
                return redirect()->back()->with('error', 'Wilayah tidak ditemukan.');
            }

            DB::beginTransaction();

            $wilayah->delete();
            DB::commit();

            return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('WilayahController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Wilayah::with('province')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('province', '{{$province["name"]}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('action', function (Wilayah $wilayah) {
                $data = [
                    'editurl' => route('wilayah.edit', $wilayah->id),
                    'deleteurl' => route('wilayah.destroy', $wilayah->id)
                ];
                return $data;
            })
        ->toJson();
    }
}
