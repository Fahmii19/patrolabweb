<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Shift;
use Throwable;

class ShiftController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Shift';
        $data['shift'] = Shift::all();
        return view('super-admin.shift.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Shift';
        return view('super-admin.shift.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();

            Shift::create($data);
            DB::commit();
            
            insert_audit_log('Create new shift data');
            return redirect()->route('shift.index')->with('success', 'Shift berhasil ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ShiftController store() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Shift';
        $data['shift'] = Shift::find($id);
        return view('super-admin.shift.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Shift';
        $data['shift'] = Shift::find($id);
        return view('super-admin.shift.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();

            Shift::find($id)->update($data);
            DB::commit();

            insert_audit_log('Update shift data');
            return redirect()->route('shift.index')->with('success', 'Shift berhasil diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ShiftController update() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            Shift::find($id)->delete();
            DB::commit();

            insert_audit_log('Delete shift data');
            return redirect()->route('shift.index')->with('success', 'Shift berhasil dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ShiftController destroy() error:' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
