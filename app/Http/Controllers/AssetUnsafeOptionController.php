<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\AssetUnsafeOption;
use Illuminate\Auth\Notifications\ResetPassword;
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
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
        
            // Membuat data aset dengan filename gambar
            $option = AssetUnsafeOption::create([
                'option_condition' => $request->nama,
                'status' => 'ACTIVED',
            ]);

            DB::commit();
            if($option) {
                return redirect()->route('aset-unsafe-option.index')->with('success', 'Data unsafe option berhasil ditambahkan');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'Data unsafe option gagal ditambahkan');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('AsetUnsafeOptionController store ' . $e->getMessage());
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
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'status' => 'nullable|in:ACTIVED,UNACTIVED',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
    
            $data['option_condition'] = $request->name;
            $data['status'] = $request->status ?? 'UNACTIVED';

            $option = AssetUnsafeOption::find($id);
            $action = $option->update($data);
            DB::commit();

            if($action) {
                return redirect()->route('aset-unsafe-option.index')->with('success', 'Data unsafe option berhasil diupdate');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'Data unsafe option gagal diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('AsetUnsafeOptionController update ' . $e->getMessage());
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
            return redirect()->route('aset-unsafe-option.index')->with('success', 'Asset Unsafe Option Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AssetUnsafeOptionController destroy() ' . $e->getMessage());
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
