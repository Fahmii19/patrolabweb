<?php

namespace App\Http\Controllers;

use Throwable;
// use App\Models\Guard;
use App\Models\Area;
use App\Models\Pleton;
use App\Models\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PletonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pletonData = Pleton::withCount('guards')->get();
        // dd($pletonData);

        $data['title'] = "Daftar Pleton";
        return view('super-admin.pleton-page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Tambah Pleton';
        $data['area'] = Area::all();
        return view('super-admin.pleton-page.create', $data);
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
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'status' => 'required|in:ACTIVED,INACTIVED',
                'area_id' => 'required|integer|exists:areas,id'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $validatedData = $validator->validated();

            $pleton = new Pleton();
            $pleton->name = $validatedData['name'];
            $pleton->code = $validatedData['code'];
            $pleton->status = $validatedData['status'];
            $pleton->area_id = $validatedData['area_id'];
            $pleton->save();

            DB::commit();
            return redirect()->route('pleton.index')->with('success', 'Pleton berhasil ditambahkan.');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('PletonController store() ' . $e->getMessage());
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
        $pleton = Pleton::with('area')->findOrFail($id);
        $title = "Detail Pleton";

        // Mengirim data ke view
        return view('super-admin.pleton-page.show', compact('pleton', 'title'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pleton = Pleton::findOrFail($id);
        $areas = Area::all(); // Get all areas

        return view('super-admin.pleton-page.edit', [
            'title' => 'Edit Pleton',
            'pleton' => $pleton,
            'areas' => $areas // Pass areas to the view
        ]);
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
        // Validasi request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:pleton,code,' . $id,
            'status' => 'required|in:ACTIVED,INACTIVED',
            'area_id' => 'required|exists:areas,id' // Ensure area_id exists in areas table
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Mencari dan memperbarui Pleton
        $pleton = Pleton::findOrFail($id);
        $pleton->name = $request->name;
        $pleton->code = $request->code;
        $pleton->status = $request->status;
        $pleton->area_id = $request->area_id;
        $pleton->save();

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('pleton.index')->with('success', 'Pleton berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mencari data Pleton berdasarkan ID
        $pleton = Pleton::findOrFail($id);

        // Melakukan penghapusan data
        $pleton->delete();

        // Mengirimkan pesan sukses setelah penghapusan
        return redirect()->route('pleton.index')->with('success', 'Pleton berhasil dihapus');
    }


    public function datatable()
    {
        $data = Pleton::with('area')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($pleton) {
                return $pleton->name;
            })
            ->addColumn('code', function ($pleton) {
                return $pleton->code;
            })
            ->addColumn('status', function ($pleton) {
                return $pleton->status;
            })
            ->addColumn('area', function ($pleton) {
                // dd($pleton->area);
                // Assuming 'name' is the field you want to display from the Area model
                return $pleton->area->name ?? 'N/A'; // Use a fallback if the area is not set
            })
            ->addColumn('action', function ($pleton) {
                return [
                    'showurl' => route('pleton.show', $pleton->id),
                    'editurl' => route('pleton.edit', $pleton->id),
                    'deleteurl' => route('pleton.destroy', $pleton->id)
                ];
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
