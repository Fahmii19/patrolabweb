<?php

namespace App\Http\Controllers;

use App\Models\CheckPoint;
use App\Models\Guard;
use App\Models\PatrolCheckpointLog;
use App\Models\Round;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'title' => "Dashboard Super Admin Patrol ABB",
            'guard' => Guard::count(),
            'round' => Round::count(),
            'checkpoint' => CheckPoint::count(),
            'missed' => $this->count_monthly_missed()
        ];
        return view('super-admin.dashboard',$data);
    }

    public function count_monthly_missed()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $today = Carbon::now();
        $totalDayOfMonth = $startDate->diffInDays($today) + 1;

        $checkpoints = DB::table('checkpoint')
            ->leftJoin('patrol_checkpoint_log', function ($join) use ($startDate, $endDate) {
                $join->on('checkpoint.id', '=', 'patrol_checkpoint_log.checkpoint_id')
                    ->whereDate('patrol_checkpoint_log.business_date', '>=', $startDate)
                    ->whereDate('patrol_checkpoint_log.business_date', '<=', $endDate);
            })
            ->groupBy('checkpoint.id') // Tambahkan 'checkpoint.name' ke dalam GROUP BY
            ->select('checkpoint.id', DB::raw('COUNT(patrol_checkpoint_log.id) as actual_visit_count'))
        ->get();

        $totalVisitedCheckpoints = 0;

        foreach ($checkpoints as $checkpoint) {
            $totalVisitedCheckpoints += $checkpoint->actual_visit_count;
        }

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

        // $targetDate = Carbon::create(2023, 12, 23);
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
