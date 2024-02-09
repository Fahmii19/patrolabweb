<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\LocationConditionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LocationConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Location Condition Option";
        return view('super-admin.location-condition.index', $data);
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
        $data['title'] = "Edit Location Condition Option";
        $data['location'] = LocationConditionOption::findOrFail($id);

        return view('super-admin.location-condition.edit', $data);
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

            $validator = Validator::make($request->all(), [
                'option_condition' => 'required|string',
                'description' => 'nullable|string',
                'status' => 'nullable|in:ACTIVED,INACTIVED',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $location = LocationConditionOption::find($id);
            
            $data = $validator->validated();
            $data['status'] = $data['status'] ?? 'INACTIVED';
            $data['created_at'] = $location->created_at;
            $data['updated-at'] = now();

            $location->update($data);
            DB::commit();

            insert_audit_log('Update data location condition option');
            redis_reset_api('location-condition-option');
            return redirect()->route('location-condition.index')->with('success', 'Location condition option berhasil diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('LocationConditionContoller update() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
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
        //
    }

    public function datatable() 
    {
        $data = LocationConditionOption::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$option_condition}}')
            ->addColumn('description', '{{$description}}')
            ->addColumn('status', '{{$status}}')
            ->addColumn('action', function (LocationConditionOption $location) {
                $data = [
                    'editurl' => route('location-condition.edit', $location->id),
                ];
                return $data;
            })
        ->toJson();
    }
}
