<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Area;
use App\Models\Round;
use App\Models\PatrolArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoundController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Round';
        return view('super-admin.round.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Round';
        if (auth()->user()->hasRole('admin-area')) {
            $area_id = explode(',', auth()->user()->access_area);
        
            $data['area'] = Area::whereIn('id', $area_id)->get();
        } else {
            $data['area'] = Area::all();
        }

        return view('super-admin.round.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'patrol_area_id' => 'required|numeric',
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $data = $validator->validated();
            $data['status'] = "ACTIVED";
            $data['created_at'] = now();
            $data['updated_at'] = null;

            Round::create($data);
            DB::commit();

            insert_audit_log('Insert data round');
            return redirect()->route('round.index')->with('success', 'Round berhasil ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('RoundController store() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Round';
        if (auth()->user()->hasRole('admin-area')) {
            $area_id = explode(',', auth()->user()->access_area);
        
            $data['area'] = Area::whereIn('id', $area_id)->get();
            $data['patrol_area'] = PatrolArea::whereIn('area_id', $area_id)->get();
            $data['round'] = Round::with('patrol_area.area')->whereIn('patrol_area_id', 
                function ($query) use ($area_id) {
                    $query->select('id')->from('patrol_area')
                        ->whereIn('area_id', $area_id);
                })
            ->get();
        } else {
            $data['area'] = Area::all();
            $data['patrol_area'] = PatrolArea::all();
            $data['round'] = Round::all();
        }
        
        return view('super-admin.round.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = "Edit Round";
        $data['round'] = Round::with(['patrol_area' => function($query) {
            $query->select('id', 'name', 'area_id');
        }])->find($id);

        if (!$data['round']) {
            return redirect()->back()->with('error', 'Round tidak ditemukan.');
        }

        if (auth()->user()->hasRole('admin-area')) {
            $area_id = explode(',', auth()->user()->access_area);
        
            $data['area'] = Area::whereIn('id', $area_id)->get();
        } else {
            $data['area'] = Area::all();
        }

        $data['patrol_area'] = PatrolArea::where('area_id', $data['round']->patrol_area->area_id)->get();

        return view('super-admin.round.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $round = Round::find($id);

            $validator = Validator::make($request->all(), [
                'patrol_area_id' => 'required|numeric',
                'name' => 'required|string',
                'status' => 'nullable|in:ACTIVED,INACTIVED'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $data = $validator->validated();
            $data['status'] = $data['status'] ?? 'INACTIVED';
            $data['created_at'] = $round->created_at;
            $data['updated_at'] = now();

            $round->update($data);
            DB::commit();

            insert_audit_log('Update data round');
            redis_reset_api('round/spesific/'.$id);
            return redirect()->route('round.index')->with('success', 'Round berhasil diperbarui');
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('RoundController update() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Round::find($id)->delete();
            DB::commit();

            insert_audit_log('Delete data round');
            redis_reset_api('round/spesific/'.$id);
            return redirect()->route('round.index')->with('success', 'Route Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('RoundController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Round::with('patrol_area.area');
        if(auth()->user()->hasRole('admin-area')){
            $area_id = explode(',', auth()->user()->access_area);

            $data->whereIn('patrol_area_id', function ($query) use ($area_id) {
                $query->select('id')->from('patrol_area')
                    ->whereIn('area_id', $area_id);
            });
        }

        $row = $data->get();
        return DataTables::of($row)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('jumlah', function($data){
                $checkpoint = Round::find($data->id)->checkpoint;
                return $checkpoint->count();
            })
            ->addColumn('status', '{{$status}}')
            ->addColumn('patrol_area', '{{$patrol_area["name"]}}')
            ->addColumn('area', '{{$patrol_area["area"]["name"]}}')
            ->addColumn('action', function (Round $round) {
                $data = [
                    'editurl' => route('round.edit', $round->id),
                    'deleteurl' => route('round.destroy', $round->id)
                ];
                return $data;
            })
        ->toJson();
    }

    public function by_patrol_area(Request $request, $id)
    {
        try {
            $old = [];
            if ($id != 0) {
                $old = $request->patrol_area_id;
                $data = Round::where('patrol_area_id', $id)->get();
            } else {
                if (auth()->user()->hasRole('admin-area')) {
                    $area_id = explode(',', auth()->user()->access_area);
                
                    $data = Round::with('patrol_area.area')
                        ->whereHas('patrol_area', function ($query) use ($area_id) {
                            $query->whereIn('area_id', $area_id);
                        })->get();
                }  else {
                    $data = Round::all();
                }
            }

            if ($data->count() <= 0) {
                return response()->json([
                    "status" => "false",
                    "messege" => "gagal mengambil data round",
                    "data" => []
                ], 404);
            }
            $html = '<option value="0" selected>--Semua--</option>';
            foreach ($data as $item) {
                $selected = $item->id == $old ? 'selected' : '';
                $html .= '<option value="' . $item->id . '"' . $selected . '>' . $item->name . '</option>';
            }
            return response()->json([
                "status" => "true",
                "messege" => "berhasil mengambil data round",
                "data" => [$html]
            ], 200);
        } catch (Throwable $th) {
            Log::debug($th->getMessage());
        }
    }
}
