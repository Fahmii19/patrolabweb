<?php

namespace App\Http\Controllers;

use App\Models\CheckpointReport;
use App\Models\PatrolCheckpointLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
        
        $data = PatrolCheckpointLog::with(['checkpoint', 'guards.shift'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('checkpoint_name', '{{$checkpoint["name"]}}')
            ->addColumn('checkpoint_loc', '{{$checkpoint["location"]}}')
            ->addColumn('guard', '{{$guards["name"]}}')
            ->addColumn('shift', '{{$guards["shift"]["name"]}}')
            ->addColumn('patrol_date', '{{$patrol_date}}')
            ->addColumn('start_time', '{{$start_time}}')
            ->addColumn('finish_time', '{{$finish_time}}')
        ->toJson();
    }
}