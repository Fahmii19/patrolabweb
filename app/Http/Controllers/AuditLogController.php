<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AuditLogController extends Controller
{
    public function index()
    {
        $data['title'] = 'Daftar Audit Log';
        $data['page'] = 'audit-log';
        $data['audit_log'] = AuditLog::all();
        return view('super-admin.audit-log.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Audit Log';
        return view('super-admin.audit-log.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'activity' => 'required',
                'subject' => 'required',
                'causer' => 'required',
                'role_causer' => 'required',
                'note' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            AuditLog::create($data);
            DB::commit();
            return redirect()->route('audit-log.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AuditLogController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Audit Log';
        $data['audit_log'] = AuditLog::find($id);
        return view('super-admin.audit-log.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Audit Log';
        $data['audit_log'] = AuditLog::find($id);
        return view('super-admin.audit-log.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'activity' => 'required',
                'subject' => 'required',
                'causer' => 'required',
                'role_causer' => 'required',
                'note' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            AuditLog::find($id)->update($data);
            DB::commit();
            return redirect()->route('audit-log.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AuditLogController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            AuditLog::find($id)->delete();
            DB::commit();

            return redirect()->route('audit-log.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AuditLogController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = AuditLog::with(['users' => function($query){
            $query->select('id', 'name');
        }])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('subject', '{{$users["name"]}}')
            ->addColumn('role', function(AuditLog $audit){
                $userRoles = $audit->users->getRoleNames()->toArray();
                return !empty($userRoles) ? $userRoles[0] : 'No Role';
            })
            ->addColumn('activity', '{{$activity}}')
            ->addColumn('datetime', function ($data) {
                return date('m/d/Y H:i:s', strtotime($data->created_at));
            })
        ->toJson();
    }
}
