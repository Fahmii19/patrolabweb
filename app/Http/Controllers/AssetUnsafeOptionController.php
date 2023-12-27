<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\AssetUnsafeOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AssetUnsafeOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Asset Unsafe Option";
        return view('super-admin.aset-unsafe-option.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'nama' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
        
            // Membuat data aset dengan filename gambar
            AssetUnsafeOption::create([
                'option_condition' => $request->nama,
                'status' => 'ACTIVED',
                'created_at' => now(),
                'updated_at' => null,
            ]);

            DB::commit();

            return redirect()->route('aset-unsafe-option.index')->with('success', 'Aset unsafe option berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('AsetUnsafeOptionController store() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
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
        $data['title'] = "Edit Asset Unsafe Option";
        $data['option'] = AssetUnsafeOption::findOrFail($id);

        return view('super-admin.aset-unsafe-option.edit', $data);
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
                'name' => 'required|string',
                'status' => 'nullable|in:ACTIVED,INACTIVED',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $option = AssetUnsafeOption::find($id);
    
            $data['option_condition'] = $request->name;
            $data['status'] = $request->status ?? 'INACTIVED';
            $data['created_at'] = $option->created_at;
            $data['updated-at'] = now();

            $option->update($data);
            DB::commit();

            return redirect()->route('aset-unsafe-option.index')->with('success', 'Aset unsafe option berhasil diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('AsetUnsafeOptionController update() error:' . $e->getMessage());
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
            DB::beginTransaction();
            AssetUnsafeOption::find($id)->delete();
            DB::commit();

            return redirect()->route('aset-unsafe-option.index')->with('success', 'Aset unsafe option berhasil dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AssetUnsafeOptionController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable() 
    {
        $data = AssetUnsafeOption::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$option_condition}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('action', function (AssetUnsafeOption $asset) {
                $data = [
                    'editurl' => route('aset-unsafe-option.edit', $asset->id),
                    'deleteurl' => route('aset-unsafe-option.destroy', $asset->id)
                ];
                return $data;
            })
        ->toJson();
    }
}
