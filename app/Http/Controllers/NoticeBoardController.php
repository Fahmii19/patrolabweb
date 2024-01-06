<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Exception;
use Throwable;
use App\Models\NoticeBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Daftar Notice Boards';
        return view('super-admin.notice-board.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Tambah Notice Board';
        $data['area'] = Area::all();
        return view('super-admin.notice-board.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $validator = Validator::make($request->all(), [
                'area_id' => 'required|numeric',
                'title' => 'required|string',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $data['created_at'] = now();
            $data['updated_at'] = null;

            NoticeBoard::create($data);
            DB::commit();

            insert_audit_log('Insert data notice board');
            return redirect()->route('notice-boards.index')->with('success', 'Notice Board berhasil ditambahhkan');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('NoticeBoardController store() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Notice Board gagal ditambahkan: ' . $e->getMessage());
        }
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
        $data['title'] = "Edit Notice Board";
        $data['area'] = Area::all();
        $data['notice_board'] = NoticeBoard::find($id);

        if (!$data['notice_board']) {
            return redirect()->back()->with('error', 'Notice Board tidak ditemukan.');
        }

        return view('super-admin.notice-board.edit', $data);
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

            // Validasi input
            $validator = Validator::make($request->all(), [
                'area_id' => 'required|numeric',
                'title' => 'required|string',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $noticeBoard = NoticeBoard::find($id);

            $data = $validator->validated();
            $data['created_at'] = $noticeBoard->created_at;
            $data['updated_at'] = now();
            
            $noticeBoard->update($data);
            DB::commit();

            insert_audit_log('Update data notice board');
            return redirect()->route('notice-boards.index')->with('success', 'Notice Board berhasil diupdate');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('NoticeBoardController update() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Notice Board gagal diupdate: ' . $e->getMessage());
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
        try {
            DB::beginTransaction();

            $noticeBoard = NoticeBoard::find($id);

            $noticeBoard->delete();
            DB::commit();

            insert_audit_log('Delete data notice board');
            return redirect()->route('notice-boards.index')->with('success', 'Notice Board berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('NoticeBoardController destroy() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Notice Board gagal dihapus: ' . $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = NoticeBoard::with(['area'], function($query){
            $query->select('id', 'name');
        })->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('area', '{{$area["name"]}}')
            ->addColumn('title', '{{$title}}')
            ->addColumn('description', '{{$description}}')
            ->addColumn('created_at', function ($data) {
                return date('m/d/Y H:i:s', strtotime($data->created_at));
            })
            ->addColumn('action', function (NoticeBoard $row) {
                $data = [
                    'editurl' => route('notice-boards.edit', $row->id),
                    'deleteurl' => route('notice-boards.destroy', $row->id)
                ];
                return $data;
            })
        ->toJson();
    }
}
