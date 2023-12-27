<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Area;
use App\Models\Pleton;
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
                'area_id' => 'required|integer|exists:areas,id',
                'code' => 'required|string|max:255|unique:pleton',
                'name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $validatedData = $validator->validated();

            $pleton = new Pleton();
            $pleton->name = $validatedData['name'];
            $pleton->code = $validatedData['code'];
            $pleton->status = 'ACTIVED';
            $pleton->area_id = $validatedData['area_id'];

            $pleton->save();
            DB::commit();

            return redirect()->route('pleton.index')->with('success', 'Pleton berhasil ditambahkan.');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('PletonController store() error:' . $e->getMessage());
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

        if (!$pleton) {
            return redirect()->back()->with('error', 'Pleton tidak ditemukan.');
        }

        // Mengirim data ke view
        return view('super-admin.pleton-page.show', [
            'title' => 'Detail Pleton',
            'pleton' => $pleton,
        ]);
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

        if (!$pleton) {
            return redirect()->back()->with('error', 'Pleton tidak ditemukan.');
        }

        return view('super-admin.pleton-page.edit', [
            'title' => 'Edit Pleton',
            'pleton' => $pleton,
            'areas' => $areas
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
        try {
            DB::beginTransaction();
            // Validasi request
            $validator = Validator::make($request->all(), [
                'area_id' => 'required|exists:areas,id',
                'code' => 'required|string|max:255|unique:pleton,code,' . $id,
                'name' => 'required|string|max:255',
                'status' => 'nullable|in:ACTIVED,INACTIVED',
            ]);

            // Cek jika validasi gagal
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();

            $pleton = Pleton::findOrFail($id);
            $pleton->name = $data['name'];
            $pleton->code = $data['code'];
            $pleton->status = $data['status'] ?? 'INACTIVED';
            $pleton->area_id = $data['area_id'];

            $pleton->save();
            DB::commit();

            return redirect()->route('pleton.index')->with('success', 'Pleton berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('PletonController update() error:' . $e->getMessage());
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
            $pleton = Pleton::findOrFail($id);
            DB::beginTransaction();

            $pleton->delete();
            DB::commit();

            return redirect()->route('pleton.index')->with('success', 'Pleton berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('PletonController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Pleton gagal dihapus: ' . $e->getMessage());
        }
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
                return $pleton->area->name ?? '-'; 
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
