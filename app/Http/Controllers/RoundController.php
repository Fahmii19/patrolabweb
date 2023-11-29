<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Area;
use App\Models\ProjectModel;
use App\Models\Round;
use App\Models\Wilayah;
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
        // $data['round'] = Round::all();
        return view('super-admin.round.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Round';
        $data['wilayah'] = Wilayah::all();
        return view('super-admin.round.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'id_wilayah' => 'required|numeric',
                'id_project' => 'required|numeric',
                'id_area' => 'required|numeric',
                'rute' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data['status'] = 'ACTIVED';

            Round::create($data);
            DB::commit();
            return redirect()->route('round.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('RoundController store error ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Round';
        $data['round'] = Round::all();
        return view('super-admin.round.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Round';
        $data['round'] = Round::find($id);
        $data['wilayah'] = Wilayah::all();
        $data['project'] = Wilayah::find($data['round']->id_wilayah)->projects;
        $data['area'] = ProjectModel::find($data['round']->id_project)->areas;
        return view('super-admin.round.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'id_wilayah' => 'required|numeric',
                'id_project' => 'required|numeric',
                'id_area' => 'required|numeric',
                'rute' => 'required|string',
                'status' => 'nullable|in:ACTIVED,INACTIVED',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            
            $data = $validator->validated();
            $data['status'] = $data['status'] ?? 'INACTIVED';

            Round::find($id)->update($data);
            DB::commit();
            return redirect()->route('round.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('RoundController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Round::find($id)->delete();
            DB::commit();
            return redirect()->route('round.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('RoundController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Round::with('wilayah', 'project', 'area')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->escapeColumns('active')
        ->addColumn('nama', '{{$rute}}')
        ->addColumn('jumlah', function($data){
            $checkpoint = Round::find($data->id)->checkpoint;
            return $checkpoint->count();
        })
        ->addColumn('status', '{{$status}}')
        ->addColumn('id_area', '{{$area["name"]}}')
        ->addColumn('id_project', '{{$project["name"]}}')
        ->addColumn('id_wilayah', '{{$wilayah["nama"]}}')
        ->addColumn('action', function (Round $round) {
            $data = [
                'editurl' => route('round.edit', $round->id),
                'deleteurl' => route('round.destroy', $round->id)
            ];
            return $data;
        })

        ->toJson();
    }
}
