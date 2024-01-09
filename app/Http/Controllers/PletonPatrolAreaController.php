<?php

namespace App\Http\Controllers;

use App\Models\PatrolArea;
use App\Models\Pleton;
use Exception;
use Throwable;
use App\Models\PletonPatrolArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PletonPatrolAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Pleton Patrol Area";
        return view('super-admin.pleton-patrol.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Tambah Pleton Patrol';
        $selectedPletonIds = PletonPatrolArea::pluck('pleton_id')->toArray();

        if (auth()->user()->hasRole('admin-area')) {
            $area_ids = explode(',', auth()->user()->access_area);
        
            $data['patrol_area'] = PatrolArea::whereIn('area_id', $area_ids)->get();
            $data['pleton'] = Pleton::whereNotIn('id', $selectedPletonIds)->whereIn('area_id', $area_ids)->get();
        } else {
            $data['patrol_area'] = PatrolArea::all();
            $data['pleton'] = Pleton::whereNotIn('id', $selectedPletonIds)->get();
        }
        
        return view('super-admin.pleton-patrol.create', $data);
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
                'pleton_id' => 'required|numeric',
                'patrol_area_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data['created_at'] = now();
            $data['updated_at'] = null;

            PletonPatrolArea::create($data);
            DB::commit();

            insert_audit_log('Insert data pleton patrol area');
            return redirect()->route('pleton-patrol-area.index')->with('success', 'Pleton patrol area berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('PletonPatrolAreaController store() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Pleton patrol area gagal ditambahkan: ' . $e->getMessage());
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
        $data['title'] = 'Edit Pleton Patrol Area';
        $pletonPatrol = PletonPatrolArea::find($id);

        if(!$pletonPatrol){
            return redirect()->back()->with('error', 'Pleton patrol area tidak ditemukan.');
        }

        $data['pleton_patrol'] = $pletonPatrol;
        if (auth()->user()->hasRole('admin-area')) {
            $area_ids = explode(',', auth()->user()->access_area);
        
            $data['patrol_area'] = PatrolArea::whereIn('area_id', $area_ids)->get();
        } else {
            $data['patrol_area'] = PatrolArea::all();
        }
        $data['pleton'] = Pleton::where('id', $pletonPatrol->pleton_id)->first();

        return view('super-admin.pleton-patrol.edit', $data);
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

            $pletonPatrol = PletonPatrolArea::find($id);

            if(!$pletonPatrol){
                return redirect()->back()->with('error', 'Pleton patrol area tidak ditemukan.');
            }

            $validator = Validator::make($request->all(), [
                'pleton_id' => 'required|numeric',
                'patrol_area_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data['created_at'] = $pletonPatrol->created_at;
            $data['updated_at'] = now();

            $pletonPatrol->update($data);
            DB::commit();

            insert_audit_log('Update pleton patrol area');
            return redirect()->route('pleton-patrol-area.index')->with('success', 'Pleton patrol area berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('PletonPatrolAreaController update() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Pleton patrol area gagal diperbarui: ' . $e->getMessage());
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
            $pletonPatrol = PletonPatrolArea::find($id);
            if (!$pletonPatrol) {
                return redirect()->back()->with('error', 'Pleton patrol area tidak ditemukan.');
            }

            $pletonPatrol->delete();
            DB::commit();

            insert_audit_log('Delete data pleton patrol area');
            redis_reset_api('pleton-patrolarea');
            return redirect()->route('pleton-patrol-area.index')->with('success', 'Pleton patrol area berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('PletonPatrolAreaController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Pleton patrol area gagal dihapus: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = PletonPatrolArea::with('pleton', 'patrol_area');

        if(auth()->user()->hasRole('admin-area')){
            $area_id = explode(',', auth()->user()->access_area);

            $data->whereHas('patrol_area', function ($query) use ($area_id) {
                $query->whereIn('area_id', $area_id);
            });
        }

        $row = $data->get();
        return DataTables::of($row)
            ->addIndexColumn()
            ->escapeColumns([])
            ->addColumn('patrol_area', '{{$pleton["name"]}}')
            ->addColumn('pleton', '{{$patrol_area["name"]}}')
            ->addColumn('action', function (PletonPatrolArea $data) {
                return [
                    'editurl' => route('pleton-patrol-area.edit', $data->id),
                    'deleteurl' => route('pleton-patrol-area.destroy', $data->id),
                ];
            })
        ->toJson();
    }
}
