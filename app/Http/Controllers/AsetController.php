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
        $data['title'] = "Daftar Asset";
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
                'code' => 'required|string|unique:asset_patrol_master',
                'name' => 'required|string',
                'short_desc' => 'nullable',
                'asset_master_type' => 'required|in:PATROL,CLIENT',
                'image' => 'image|mimes:jpeg,png,jpg',
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

            $data = $validator->validated();
            $data['status'] = 'ACTIVED';
            $data['image'] = $filename;

            if(Aset::create($data)){
                DB::commit();
                return redirect()->route('aset.index')->with('success', 'Aset berhasil ditambahkan');
            }

            DB::rollback();
            return redirect()->route('aset.index')->with('error', 'Aset gagal ditambahkan');
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
                'code' => 'required|string|unique:asset_patrol_master,code,'.$aset->id,
                'name' => 'required|string',
                'asset_master_type' => 'required|in:PATROL,CLIENT',
                'short_desc' => 'nullable',
                'status' => 'nullable|in:ACTIVED,INACTIVED',
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('gambar/aset'), $filename); // Sesuaikan path sesuai kebutuhan

                // Hapus gambar lama jika ada
                if ($aset->image && file_exists(public_path('gambar/aset/' . $aset->image))) {
                    unlink(public_path('gambar/aset/' . $aset->image));
                }

                // Menyimpan nama file gambar baru
                $data['image'] = $filename; 
            }

            $data['status'] = $request->status ?? 'INACTIVED';

            if($aset->update($data)){
                DB::commit();
                return redirect()->route('aset.index')->with('success', 'Aset berhasil diupdate');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'Aset gagal diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('AsetController update() error: ' . $e->getMessage());
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
        try {
            DB::beginTransaction();

            // Hapus gambar dari server jika ada
            if ($aset->image) {
                if (file_exists(public_path('gambar/area/' . $aset->image))) {
                    unlink(public_path('gambar/area/' . $aset->image));
                }
            }

            // Hapus data area
            if($aset->delete()){
                DB::commit();
                return redirect()->route('aset.index')->with('success', 'Aset berhasil dihapus');
            }

            DB::rollback();
            return redirect()->route('aset.index')->with('error', 'Aset gagal dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('AsetController destroy() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Aset gagal dihapus: ' . $e->getMessage());
        }
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
            ->addColumn('short_desc', '{{$short_desc ? $short_desc : "-"}}')
            ->addColumn('asset_master_type', '{{$asset_master_type}}')
            ->addColumn('action', function (Aset $aset) {
                $data = [
                    'editurl' => route('aset.edit', $aset->id),
                    'deleteurl' => route('aset.destroy', $aset->id)
                ];
                return $data;
            })
            ->addColumn('image', function ($row) {
                $imgHtml = '';
                // Cek jika file gambar ada
                if ($row->image && file_exists(public_path('gambar/aset/' . $row->image))) {
                    $url = asset('gambar/aset/' . $row->image);
                } else {
                    // Jika tidak ada, gunakan gambar default
                    $url = asset('gambar/no-image.png'); // Pastikan gambar no-image.png tersedia di folder public/gambar
                }

                $imgHtml .= '<span class="btn" data-bs-toggle="modal" data-bs-target="#imageModal' . $row->id . '"><img src="' . $url . '" border="0" width="100" class="img-rounded mr-1" align="center" /></span>';
                
                $imgHtml .= '
                    <div class="modal fade" id="imageModal' . $row->id . '" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="' . $url . '" class="img-fluid">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                return $imgHtml;
            })
            ->rawColumns(['image'])
            ->toJson();
    }
}
