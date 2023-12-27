<?php

use App\Http\Controllers\AdminAreaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\PletonController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\AtensiController;
use App\Http\Controllers\ApiDocsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\CheckPointController;
use App\Http\Controllers\SelfPatrolController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AsetPatroliController;
use App\Http\Controllers\AiMasterDataController;
use App\Http\Controllers\AsetLocationController;
use App\Http\Controllers\CheckpointAsetController;
use App\Http\Controllers\IncomingVehicleController;
use App\Http\Controllers\OutcomingVehicleController;
use App\Http\Controllers\CheckpointReportController;
use App\Http\Controllers\AssetClientCheckpointController;
use App\Http\Controllers\AssetLocationController;
use App\Http\Controllers\AssetPatrolCheckpointController;
use App\Http\Controllers\AssetReportController;
use App\Http\Controllers\AssetUnsafeOptionController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\PatrolAreaController;
use App\Http\Controllers\PletonPatrolAreaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ScheduleController;
use App\Models\PatrolArea;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
})->name('home');

Route::get('/dashboard', function () {
    if (auth()->check()) {
        // Cek hak akses super-admin
        if (auth()->user()->hasRole('super-admin')) {
            return redirect()->route('admin.dashboard');
        } 
        // Cek hak akses admin-area
        elseif (auth()->user()->hasRole('admin-area')) {
            return redirect()->route('admin-area.dashboard');
        } 
        // Default hak akses sebagai guard / user
        else {
            // Redirect ke halaman default jika hak akses sebagai user / guard
            return redirect()->route('default.dashboard');
        }
    }
    // Redirect ke login jika tidak terautentikasi
    return redirect()->route('login'); 
})->middleware(['auth', 'verified']);

//Grup Rute untuk Super Admin
Route::group(['prefix' => 'super-admin', 'middleware' => ['auth', 'verified', 'role:super-admin']], function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resources([
        // Master Data
        'user' => UserController::class,
        'province' => ProvinceController::class,
        'wilayah' => WilayahController::class, // region
        'branch' => BranchController::class,
        'project' => ProjectController::class,
        'area' => AreaController::class,
        'gate' => GateController::class,
        'aset' => AsetController::class,
        'shift' => ShiftController::class,
        // Patrol
        'schedule' => ScheduleController::class,
        'patrol-area' => PatrolAreaController::class,
        'notice-boards' => NoticeBoardController::class,
        // Guard Management
        'guard' => GuardController::class,
        'pleton' => PletonController::class,
        'pleton-patrol-area' => PletonPatrolAreaController::class,
        // Round & Checkpoint
        'round' => RoundController::class,
        'check-point' => CheckPointController::class,
        // Gate Access
        'incoming-vehicle' => IncomingVehicleController::class,
        'outcoming-vehicle' => OutcomingVehicleController::class,
        // Asset Management
        'aset-location' => AsetLocationController::class,
        'aset-unsafe-option' => AssetUnsafeOptionController::class,
        'checkpoint-aset-client' => AssetClientCheckpointController::class,
        'checkpoint-aset-patrol' => AssetPatrolCheckpointController::class,
        // Report
        'self-patrol' => SelfPatrolController::class,
        'checkpoint-report' => CheckpointReportController::class,
        'asset-report' => AssetReportController::class,

        'audit-log' => AuditLogController::class,
        
        // Unuse
        'aset-patroli' => AsetPatroliController::class,
        'ai-master' => AiMasterDataController::class,
        'hak-akses' => HakAksesController::class,
        'atensi' => AtensiController::class,
    ]);

    // Route Data Table
    // Master Data
    Route::get('user-datatable', [UserController::class, 'datatable'])->name('user.datatable');
    Route::get('province-datatable', [ProvinceController::class, 'datatable'])->name('province.datatable');
    Route::get('wilayah-datatable', [WilayahController::class, 'datatable'])->name('wilayah.datatable');
    Route::get('branch-datatable', [BranchController::class, 'datatable'])->name('branch.datatable');
    Route::get('project-datatable', [ProjectController::class, 'datatable'])->name('project.datatable');
    Route::get('area-datatable', [AreaController::class, 'datatable'])->name('area.datatable');
    Route::get('gate-datatable', [GateController::class, 'datatable'])->name('gate.datatable');
    // Patrol
    Route::get('patrol-area-datatable', [PatrolAreaController::class, 'datatable'])->name('patrol-area.datatable');
    Route::get('notice-boards-datatable', [NoticeBoardController::class, 'datatable'])->name('notice-boards.datatable');
    // Guard Management
    Route::get('guard-datatable', [GuardController::class, 'datatable'])->name('guard.datatable');
    Route::get('pleton-datatable', [PletonController::class, 'datatable'])->name('pleton.datatable');
    Route::get('pleton-patrol-datatable', [PletonPatrolAreaController::class, 'datatable'])->name('pleton-patrol.datatable');
    // Round & Checkpoint
    Route::get('round-datatable', [RoundController::class, 'datatable'])->name('round.datatable');
    Route::get('check-point-datatable', [CheckPointController::class, 'datatable'])->name('check-point.datatable');
    Route::get('checkpoint-without-round-datatable', [CheckPointController::class, 'datatable_without_round'])->name('check-point.without-round-datatable');
    // Gate Access
    Route::get('incoming-vehicle.datatable', [IncomingVehicleController::class, 'datatable'])->name('incoming-vehicle.datatable');
    Route::get('outcoming-vehicle.datatable', [OutcomingVehicleController::class, 'datatable'])->name('outcoming-vehicle.datatable');
    // Asset Management
    Route::get('aset-datatable', [AsetController::class, 'datatable'])->name('aset.datatable');
    Route::get('aset-unsafe-option-datatable', [AssetUnsafeOptionController::class, 'datatable'])->name('aset-unsafe-option.datatable');
    Route::get('aset-location-datatable', [AsetLocationController::class, 'datatable'])->name('aset-location.datatable');
    Route::get('check-point-aset.datatable', [CheckpointAsetController::class, 'datatable'])->name('check-point-aset.datatable');
    Route::get('checkpoint-aset-client-datatable', [AssetClientCheckpointController::class, 'asset_client_datatable'])->name('checkpoint-aset-client.datatable');
    Route::get('checkpoint-aset-patrol-datatable', [AssetPatrolCheckpointController::class, 'asset_patrol_datatable'])->name('checkpoint-aset-patrol.datatable');
    Route::get('asset-client-datatable', [AssetClientCheckpointController::class, 'asset_datatable'])->name('asset-client-datatable');
    Route::get('asset-patrol-datatable', [AssetPatrolCheckpointController::class, 'asset_datatable'])->name('asset-patrol-datatable');
    // Report
    Route::get('aset-report-datatable', [AssetReportController::class, 'datatable'])->name('aset-report.datatable');
    Route::get('self-patrol-datatable', [SelfPatrolController::class, 'datatable'])->name('self-patrol.datatable');
    Route::get('checkpoint-report-datatable', [CheckpointReportController::class, 'datatable'])->name('checkpoint-report.datatable');
    //Audit Log
    Route::get('audit-log-datatable', [AuditLogController::class, 'datatable'])->name('audit-log.datatable');

    Route::get('ai-master-datatable', [AiMasterDataController::class, 'datatable'])->name('ai-master.datatable');
    Route::get('hak-akses-datatable', [HakAksesController::class, 'datatable'])->name('hak-akses.datatable');
    Route::get('atensi-datatable', [AtensiController::class, 'datatable'])->name('atensi.datatable');

    // Another Route
    Route::get('/patrol-area-by-area/{id}', [PatrolAreaController::class, 'by_area']);
    Route::get('/round/detail/', [RoundController::class, 'detail'])->name('round.detail');
    Route::delete('/checkpoint/remove-round/{id}', [CheckPointController::class, 'remove_round'])->name('checkpoint-remove-round');
    Route::put('/checkpoint/update-round/{id}', [CheckPointController::class, 'update_round'])->name('checkpoint-update-round');
    Route::get('/project-by-wilayah/{id}', [ProjectController::class, 'by_wilayah'])->name('project-by-wilayah');
    Route::get('/project-by-wilayah-select/{id}', [ProjectController::class, 'by_wilayah_select'])->name('project-by-wilayah-select');
    Route::get('/area-by-project/{id}', [AreaController::class, 'by_project'])->name('area-by-project');
    Route::get('/asset-client-detail', [AssetClientCheckpointController::class, 'detail'])->name('asset-client-detail');
    Route::get('/asset-client-by-checkpoint/{id}', [AssetClientCheckpointController::class, 'asset_by_checkpoint']);
    Route::get('/asset-patrol-detail', [AssetPatrolCheckpointController::class, 'detail'])->name('asset-patrol-detail');
    Route::get('/asset-patrol-by-checkpoint/{id}', [AssetPatrolCheckpointController::class, 'asset_by_checkpoint']);
    Route::get('checkpoint-get-all-asset/{id}', [CheckPointController::class, 'get_all_asset']);
    Route::get('checkpoint-by-round/{id}', [CheckPointController::class, 'by_round']);
    Route::get('guards/{guard}', [GuardController::class, 'show'])->name('guard.show');
    Route::post('get-hak-akses', [HakAksesController::class, 'get_hak_akses'])->name('get-hak-akses');
});

Route::group(['prefix' => 'admin-area', 'middleware' => ['auth', 'verified', 'role:super-admin|admin-area']], function () {
    Route::get('/dashboard', [AdminAreaController::class, 'dashboard'])->name('admin-area.dashboard');
    Route::resources([
        'area' => AreaController::class,
        'branch' => BranchController::class,
        'project' => ProjectController::class,
    ]);

    Route::get('area-datatable', [AreaController::class, 'datatable'])->name('area.datatable');
    Route::get('branch-datatable', [BranchController::class, 'datatable'])->name('branch.datatable');
    Route::get('project-datatable', [ProjectController::class, 'datatable'])->name('project.datatable');
});

// Grup Rute untuk Guard
Route::group(['prefix' => 'guard', 'middleware' => ['auth', 'verified', 'role:super-admin|guard|user']], function () {
    Route::get('/dashboard', [DefaultController::class, 'dashboard'])->name('default.dashboard');
    
    Route::resources([
        'guard' => GuardController::class,
        'pleton' => PletonController::class,
    ]);
    // Guard
    Route::get('/guard-datatable', [GuardController::class, 'datatable'])->name('guard.datatable');
    Route::get('/guards/{guard}', [GuardController::class, 'show'])->name('guard.show');

    //Pleton
    Route::get('pleton-datatable', [PletonController::class, 'datatable'])->name('pleton.datatable');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
