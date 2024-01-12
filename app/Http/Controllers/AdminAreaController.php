<?php

namespace App\Http\Controllers;

use App\Models\CheckPoint;
use App\Models\PatrolCheckpointLog;
use App\Models\Pleton;
use App\Models\Round;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminAreaController extends Controller
{
    public function dashboard(){
        $area_id = explode(',', auth()->user()->access_area);

        $data = [
            'title' => "Dashboard Admin Area Patrol ABB",
            'pleton' => $this->count_pleton($area_id),
            'round' => $this->count_round($area_id),
            'checkpoint' => $this->count_checkpoint($area_id),
            'missed' => $this->count_monthly_missed($area_id)
        ];
        return view('admin-area.dashboard', $data);
    }

    public function count_pleton($area_id)
    {
        return Pleton::with('area')
            ->whereHas('area', function ($query) use ($area_id) {
                $query->whereIn('area_id', $area_id);
            })
        ->count();
    }

    public function count_round($area_id)
    {
        return  Round::with('patrol_area')
            ->whereHas('patrol_area', function ($query) use ($area_id) {
                $query->whereIn('area_id', $area_id);
            })
        ->count();
    }

    public function count_checkpoint($area_id)
    {
        return CheckPoint::with('round.patrol_area.area')
            ->whereHas('round.patrol_area', function ($query) use ($area_id) {
                $query->whereIn('area_id', $area_id);
            })
        ->count();
    }

    public function select_checkpoint($area_id)
    {
        return CheckPoint::with('round.patrol_area.area')
            ->whereHas('round.patrol_area', function ($query) use ($area_id) {
                $query->whereIn('area_id', $area_id);
            })
            ->pluck('id')
        ->toArray();
    }

    public function count_monthly_missed($area_id)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $selectedCheckpoints = $this->select_checkpoint($area_id);

        $checkpoints = DB::table('checkpoint')
            ->leftJoin('patrol_checkpoint_log', function ($join) use ($startDate, $endDate) {
                $join->on('checkpoint.id', '=', 'patrol_checkpoint_log.checkpoint_id')
                    ->whereDate('patrol_checkpoint_log.business_date', '>=', $startDate)
                    ->whereDate('patrol_checkpoint_log.business_date', '<=', $endDate);
            })
            ->whereIn('checkpoint.id', $selectedCheckpoints)
            ->groupBy('checkpoint.id') // Tambahkan 'checkpoint.name' ke dalam GROUP BY
            ->select('checkpoint.id', DB::raw('COUNT(patrol_checkpoint_log.id) as actual_visit_count'))
        ->get();

        $totalVisitedCheckpoints = 0;

        foreach ($checkpoints as $checkpoint) {
            $totalVisitedCheckpoints += $checkpoint->actual_visit_count;
        }

        $today = Carbon::now();
        $totalDayOfMonth = $startDate->diffInDays($today) + 1;

        $totalMissedCheckpoints = ($totalDayOfMonth * 3) * $checkpoints->count() - $totalVisitedCheckpoints;

        return $totalMissedCheckpoints;
    }

    public function datatable(Request $request)
    {
        $query = PatrolCheckpointLog::with(
            ['user' => function($query){
                $query->select('id', 'name');
            }, 'pleton' => function($query){        
                $query->select('id', 'name');
        }]);

        // Filter berdasrkan area 
        $area_id = explode(',', auth()->user()->access_area);
        $query->whereHas('checkpoint.round.patrol_area', function ($row) use ($area_id) {
            $row->whereIn('area_id', $area_id);
        });

        $targetDate = Carbon::now();
        $data = $query->whereDate('business_date', $targetDate)->latest()->get();
        
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
