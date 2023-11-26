<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Aset::all();

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
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'status' => 'required',
            'short_desc' => 'nullable',
            'asset_master_type' => 'required',
        ]);

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
            'status' => $request->status,
            'short_desc' => $request->short_desc,
            'asset_master_type' => $request->asset_master_type,
            'image' => $filename,
        ]);

        return redirect()->route('aset.index')->with('success', 'Data Aset berhasil ditambahkan');
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
        // dd($data);
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

        // dd($request->all());

        // $request->validate([
        //     'code' => 'required',
        //     'nama' => 'required',
        //     'status' => 'required',
        //     'short_desc' => 'nullable', // Validasi untuk deskripsi singkat
        //     'asset_master_type' => 'nullable', // Validasi untuk tipe aset
        // ]);

        $aset->code = $request->code;
        $aset->name = $request->name;
        $aset->status = $request->status;
        $aset->short_desc = $request->short_desc; // Menyimpan deskripsi singkat
        $aset->asset_master_type = $request->asset_master_type; // Menyimpan tipe aset

        // Menangani upload gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('gambar/aset'), $filename); // Sesuaikan path sesuai kebutuhan

            // Hapus gambar lama jika ada
            if ($aset->image && file_exists(public_path('gambar/aset/' . $aset->image))) {
                unlink(public_path('gambar/aset/' . $aset->image));
            }

            $aset->image = $filename; // Menyimpan nama file gambar baru
        }

        $aset->save();

        return redirect()->route('aset.index')->with('success', 'Data Aset berhasil diupdate');
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
        // dd($data);
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
