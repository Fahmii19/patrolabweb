<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Provinsi";
        return view('super-admin.province.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Provinsi";
        return view('super-admin.province.create', $data);
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
                'name' => 'required|string|unique:province',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data['created_at'] = now();
            $data['updated_at'] = null;

            Province::create($data);
            DB::commit();

            insert_audit_log('Insert data province');
            return redirect()->route('province.index')->with('success', 'Provinsi berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('ProvinceController store() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Provinsi gagal ditambahkan: ' . $e->getMessage());
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
        $data['title'] = "Edit Provinsi";
        $data['province'] = Province::find($id);

        if (!$data['province']) {
            return redirect()->back()->with('error', 'Provinsi tidak ditemukan.');
        }

        return view('super-admin.province.edit', $data);
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
                'name' => 'required|string|unique:province,name,'. $id,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $province = Province::find($id);
            $data['created_at'] = $province->created_at;
            $data['updated_at'] = now();

            $province->update($data);
            DB::commit();

            insert_audit_log('Update data province');
            return redirect()->route('province.index')->with('success', 'Provinsi berhasil diedit');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('ProvinceController update() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Provinsi gagal diedit: ' . $e->getMessage());
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
            $province = Province::find($id);
            if (!$province) {
                return redirect()->back()->with('error', 'Provinsi tidak ditemukan.');
            }
            DB::beginTransaction();

            $province->delete();
            DB::commit();

            insert_audit_log('Delete data province');
            return redirect()->route('province.index')->with('success', 'Provinsi berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('ProvinceController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Provinsi gagal dihapus: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Province::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('action', function (Province $province) {
                $data = [
                    'editurl' => route('province.edit', $province->id),
                    'deleteurl' => route('province.destroy', $province->id)
                ];
                return $data;
            })
        ->toJson();
    }
}
