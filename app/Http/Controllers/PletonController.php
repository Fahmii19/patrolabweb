<?php

namespace App\Http\Controllers;

use Throwable;
// use App\Models\Guard;
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
        // $pletonData = Pleton::withCount('guards')->get();
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
        // dd("hahahahaha");
        $data['title'] = 'Tambah Pleton';
        $data['pletons'] = Pleton::all();
        // $data['guards'] = Guard::all();
        $data['guards'] = Guard::whereNull('pleton_id')->get();
        // dd($data);
        return view('super-admin.pleton-page.create',$data);
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
                'id_pleton' => 'required',
                'id_guard'=>'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $validator->validated();

            $guard = Guard::find($request->id_guard);
            // dd($guard);

            $data['pleton_id'] = $request->id_pleton;
            // dd($data);
            $guard->update($data);
            DB::commit();
            return redirect()->route('pleton.index')->with('success', 'Data Berhasil Ditambah');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('PletonController update() ' . $e->getMessage());
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function datatable()
    {
        $data = Pleton::withCount('guards')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('code', '{{$code}}')
            ->addColumn('guards_count', '{{$guards_count}}')
            // ->addColumn('created_at', function (Guard $guard) {
            //     return date('d M y', strtotime($guard->created_at));
            // })
            // ->addColumn('action', function (Guard $guard) {
            //     $data = [
            //         'showurl' => route('guard.show', $guard->id),
            //         'editurl' => route('guard.edit', $guard->id),
            //         'deleteurl' => route('guard.destroy', $guard->id)
            //     ];
            //     return $data;
            // })
            ->toJson();
    }
}
