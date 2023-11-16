<?php

namespace App\Http\Controllers;

use App\Models\CheckpointReport;
use Illuminate\Http\Request;

use Exception;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CheckpointReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar CheckPoint Report";
        return view('super-admin.checkpoint-report.index', $data);
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
     * @param  \App\Models\CheckpointReport  $checkpointReport
     * @return \Illuminate\Http\Response
     */
    public function show(CheckpointReport $checkpointReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CheckpointReport  $checkpointReport
     * @return \Illuminate\Http\Response
     */
    public function edit(CheckpointReport $checkpointReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CheckpointReport  $checkpointReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CheckpointReport $checkpointReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CheckpointReport  $checkpointReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(CheckpointReport $checkpointReport)
    {
        //
    }

    public function datatable()
    {
        $data = CheckpointReport::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('checkpoint_name_log', '{{$checkpoint_name_log}}')
            ->addColumn('checkpoint_location_log', '{{$checkpoint_location_log}}')
            ->addColumn('checkpoint_location_long_lat_log', '{{$checkpoint_location_long_lat_log}}')
            ->addColumn('shift_start_time_log', '{{$shift_start_time_log}}')
            ->addColumn('shift_end_time_log', '{{$shift_end_time_log}}')
            ->addColumn('business_date', '{{$business_date}}')
            ->toJson();
    }
}
