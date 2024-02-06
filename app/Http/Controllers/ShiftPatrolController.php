<?php

namespace App\Http\Controllers;

use App\Models\PatrolCheckpointLog;
use App\Models\Shift;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShiftPatrolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Shift Patrol Report";
        
        $data['shift'] = Shift::all();
        return view('super-admin.shift-patrol.index', $data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = "Detail Shift Patrol Report";
        $data['report'] = PatrolCheckpointLog::with([
            'user' => function($query){
                $query->select('id','name');
            },
            'pleton' => function($query){
                $query->select('id','code','name');
            },
            'shift' => function($query){
                $query->select('id','name');
            },
            'checkpoint.round.patrol_area.area',
            'asset_patrol_checkpoint_log.asset_unsafe_option'
        ])->find($id);

        // return response()->json($data);
        return view('super-admin.checkpoint-report.show', $data);
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

    public function datatable(Request $request)
    {
        $query = PatrolCheckpointLog::with(
            ['user' => function($query){
                $query->select('id', 'name');
            }, 'pleton' => function($query){        
                $query->select('id', 'name');
            }, 'shift' => function($query){
                $query->select('id', 'name');
        }]);

        if(auth()->user()->hasRole('admin-area')){
            $area_id = explode(',', auth()->user()->access_area);

            $query->whereHas('checkpoint.round.patrol_area', function ($row) use ($area_id) {
                $row->whereIn('area_id', $area_id);
            });
        }

        if($request->has('patrol_date')){
            if($request->patrol_date !== null && $request->patrol_date !== '') {
                // Split the date range into start and end dates
                // list($startDate, $endDate) = explode(' - ', $request->patrol_date);
                $explodedDates = explode(' - ', $request->patrol_date);

                // Memeriksa apakah explode berhasil
                if (count($explodedDates) === 2) {
                    // Format sesuai harapan, $startDate dan $endDate diatur
                    list($startDate, $endDate) = $explodedDates;
                } else {
                    $startDate = $request->patrol_date;
                    $endDate = $startDate;
                }
                // Convert the date strings to the format expected by the database
                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $query->whereBetween('business_date', [$startDate, $endDate]);
            }
        }

        if($request->has('shift')){
            if($request->shift !== null && $request->shift !== '') {
                $query->where('shift_id', $request->shift);
            }
        }
        
        $data = $query->get();
        
        // Menambahkan atribut 'status' ke setiap instance PatrolCheckpointLog
        $data->each(function ($log) {
            $log->append('status');
        });

        $filteredData = $data;

        if($request->has('status')){
            if($request->status !== null && $request->status !== '') {
                $filteredData = $data->filter(function ($log) use ($request) {
                    return $log->status === $request->status;
                })->values()->all();
            }
        }

        return DataTables::of($filteredData)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('shift', '{{$shift["name"]}}')
            ->addColumn('created_by', '{{$user["name"]}}')
            ->addColumn('pleton', '{{$pleton["name"]}}')
            ->addColumn('business_date', '{{$business_date}}')
            ->addColumn('checkpoint', '{{$checkpoint_name_log}}')
            ->addColumn('location', '{{$checkpoint_location_log}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('reported_at', function ($data) {
                return date('m/d/Y H:i:s', strtotime($data->created_at));
            })
        ->toJson();
    }
}