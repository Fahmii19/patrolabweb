<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\Atensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AtensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Atensi';
        $data['atensi'] = Atensi::all();
        return view('super-admin.atensi.index', $data);
    }

    public function all_data(){
        $data['atensi'] = Atensi::all();

        return response()->json([
            'status' => true,
            'message' => 'berhasil menampilkan data',
            'data' => $data
        ], 200);

    }

    public function data_per_user($id_user)
    {
       $data = Atensi::where('id_user', $id_user)->get();

        return response()->json([
            'status' => true,
            'message' => 'berhasil menampilkan data',
            'data' => $data
        ], 200);
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
            $validator = Validator::make(
                $request->all(),
                [
                    'id_user' => ['required', 'numeric'],
                    'id_wilayah' => ['required', 'numeric'],
                    'id_project' => ['required', 'numeric'],
                    'id_area' => ['required', 'numeric'],
                    'judul_atensi' => ['required'],
                    'prioritas' => ['required','in:high,medium,low'],
                    'tanggal_mulai' => ['required'],
                    'tanggal_selesai' => ['required'],
                    'deskripsi' => ['required']
                ]
            );

            //return $request->file('foto.0')->getClientOriginalExtension();

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'input tidak valid',
                    'data' => $validator->errors()
                ], 401);
            }
            $data = $validator->validated();

            $action = Atensi::create($data);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'data berhasil di simpan',
                'data' => $action
            ], 200);
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('Atensi store ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'terjadi kesalahan',
                'data' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Atensi  $atensi
     * @return \Illuminate\Http\Response
     */
    public function show(Atensi $atensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Atensi  $atensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Atensi $atensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Atensi  $atensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Atensi $atensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Atensi  $atensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atensi $atensi)
    {
        //
    }

    public function datatable()
    {
        $data = Atensi::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('user', function (Atensi $atensis) {
                return $atensis->user->name;
            })
            ->addColumn('judul', '{{$judul_atensi}}')
            ->addColumn('prioritas', '{{$prioritas}}')
            ->addColumn('wilayah', function (Atensi $atensis) {
                return $atensis->wilayah->nama;
            })
            ->addColumn('project', function (Atensi $atensis) {
                return $atensis->project->nama_project;
            })
            ->addColumn('area', function (Atensi $atensis) {
                return $atensis->area->nama;
            })
            ->addColumn('mulai', '{{$tanggal_mulai}}')
            ->addColumn('selesai', '{{$tanggal_selesai}}')
            ->addColumn('deskripsi', '{{$deskripsi}}')
            ->toJson();
    }
}
