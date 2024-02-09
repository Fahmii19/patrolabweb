<?php

namespace App\Http\Controllers;

use App\Models\AssetCheckpointLog;
use App\Models\AssetPatrolCheckpointLog;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssetReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar Asset Report";
        return view('super-admin.aset-report.index', $data);
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

    public function datatable()
    {
        $data = AssetPatrolCheckpointLog::with('asset_patrol_checkpoint.asset', 'asset_unsafe_option', 'patrol_checkpoint_log.pleton', 'patrol_checkpoint_log.checkpoint.round.patrol_area.area');
        if(auth()->user()->hasRole('admin-area')){
            $area_id = explode(',', auth()->user()->access_area);

            $data->whereHas('patrol_checkpoint_log.checkpoint.round.patrol_area', function ($query) use ($area_id) {
                $query->whereIn('area_id', $area_id);
            });
        }

        $row = $data->get();
        return DataTables::of($row)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('asset_code', '{{$asset_code_log}}')
            ->addColumn('asset_name', '{{$asset_name_log}}')
            ->addColumn('asset_type', '{{$asset_patrol_checkpoint["asset"]["asset_master_type"]}}')
            ->addColumn('pleton', '{{$patrol_checkpoint_log["pleton"]["name"]}}')
            ->addColumn('patrol_date', '{{$patrol_checkpoint_log["business_date"]}}')
            ->addColumn('asset_status', '{{$status}}')
            ->addColumn('asset_info', '{{$asset_unsafe_option_id ? $asset_unsafe_option["option_condition"] : "-"}}')
            ->addColumn('description', '{{$unsafe_description ? $unsafe_description : "-"}}')
            ->addColumn('image', function ($row) {
                $images = $row->unsafe_images;
                $imageArray = explode(',', $images);

                // Ambil URL gambar pertama
                $imageUrl = null;
                if ($images && count($imageArray) > 0) {
                    $imageUrl = check_img_path(trim($imageArray[0]));
                } else {
                    // Jika tidak ada gambar, gunakan gambar default
                    $imageUrl = asset('gambar/no-image.png');
                }

                return '<img src="' . $imageUrl . '" alt="'.$imageArray[0].'" border="0" width="100" class="img-rounded" align="center" />';
            })
            ->rawColumns(['image'])
        ->toJson();
    }
}
