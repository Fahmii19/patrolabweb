<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Aset;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Master data Aset";
        return view('super-admin.aset.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Aset";
        return view('super-admin.aset.create', $data);
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
                'kode' => 'required|string',
                'nama' => 'required|string',
                'asset_master_type' => 'required|in:PATROL,CLIENT',
                'short_desc' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
    
            // Inisialisasi nama file
            $filename = null;
    
            // Menangani upload gambar
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $currentDateTime = date('Ymd_His');
                $filename = $currentDateTime . '_' . $file->getClientOriginalName();
    
                // Pindahkan file ke direktori publik
                $file->move(public_path('gambar/aset'), $filename);
            }
    
            // Membuat data aset dengan filename gambar
            $aset = Aset::create([
                'code' => $request->kode,
                'name' => $request->nama,
                'status' => 'ACTIVED',
                'short_desc' => $request->short_desc,
                'asset_master_type' => $request->asset_master_type,
                'image' => $filename,
            ]);

            DB::commit();
            if($aset) {
                return redirect()->route('aset.index')->with('success', 'Data Aset berhasil ditambahkan');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'Data aset gagak ditambahkan');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('AsetController store ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function show(Aset $aset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function edit(Aset $aset)
    {
        $data['title'] = "Edit Data Aset";
        $data['aset'] = $aset;
        return view('super-admin.aset.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aset $aset)
    {   
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string',
                'name' => 'required|string',
                'asset_master_type' => 'required|in:PATROL,CLIENT',
                'short_desc' => 'nullable',
                'status' => 'nullable|in:ACTIVED,INACTIVED',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('gambar/aset'), $filename); // Sesuaikan path sesuai kebutuhan

                // Hapus gambar lama jika ada
                if ($aset->image && file_exists(public_path('gambar/aset/' . $aset->image))) {
                    unlink(public_path('gambar/aset/' . $aset->image));
                }

                // Menyimpan nama file gambar baru
                $aset->image = $filename; 
            }

            $aset->code = $request->code;
            $aset->name = $request->name;
            $aset->status = $request->status ?? 'INACTIVED';
            $aset->short_desc = $request->short_desc; 
            $aset->asset_master_type = $request->asset_master_type;

            $action = $aset->save();
            DB::commit();

            if($action){
                return redirect()->route('aset.index')->with('success', 'Data Aset berhasil diupdate');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'Data Aset gagal diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('AsetController update ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aset $aset)
    {
        // hapus data
        $aset->delete();
        return redirect()->route('aset.index')->with('success', 'Data Aset berhasil dihapus');
    }

    public function datatable()
    {
        $data = Aset::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('code', '{{$code}}')
            ->addColumn('name', '{{$name}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('short_desc', '{{$short_desc}}')
            ->addColumn('asset_master_type', '{{$asset_master_type}}')
            ->addColumn('action', function (Aset $aset) {
                $data = [
                    'editurl' => route('aset.edit', $aset->id),
                    'deleteurl' => route('aset.destroy', $aset->id)
                ];
                return $data;
            })
            ->addColumn('image', function ($row) {
                // Cek jika file gambar ada
                if ($row->image && file_exists(public_path('gambar/aset/' . $row->image))) {
                    $url = asset('gambar/aset/' . $row->image);
                } else {
                    // Jika tidak ada, gunakan gambar default
                    $url = asset('gambar/no-image.png'); // Pastikan gambar no-image.png tersedia di folder public/gambar
                }
                return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
            })
            ->rawColumns(['image'])
            ->toJson();
    }
}
