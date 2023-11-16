<?php

use App\Models\AuditLog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
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
use App\Http\Controllers\ProjectModelController;
use App\Http\Controllers\CheckpointAsetController;
use App\Http\Controllers\IncomingVehicleController;
use App\Http\Controllers\OutcomingVehicleController;
use App\Http\Controllers\CheckpointReportController;
use App\Models\IncomingVehicle;

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
    return redirect('/dashboard'); })->name('home');

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('super-admin')) {
        return redirect()->route('admin.dashboard');
    }
})->middleware(['auth', 'verified']);
//Route::get('/dashboard',[SuperAdminController::class,'dashboard'])->middleware(['auth', 'verified','role:super-admin'])->name('dashboard');
//admin route
Route::group(['prefix' => 'super-admin', 'middleware' => ['auth', 'verified', 'role:super-admin']], function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resources([
        'user' => UserController::class,
        'wilayah' => WilayahController::class,
        'area' => AreaController::class,
        'check-point' => CheckPointController::class,
        'guard' => GuardController::class,
        'pleton' => PletonController::class,
        'ai-master' => AiMasterDataController::class,
        'aset' => AsetController::class,
        'hak-akses' => HakAksesController::class,
        'project-model' => ProjectModelController::class,
        'aset-location' => AsetLocationController::class,
        'aset-patroli' => AsetPatroliController::class,
        'shift'=>ShiftController::class,
        'audit-log' => AuditLogController::class,
        'incoming-vehicle' => IncomingVehicleController::class,
        'outcoming-vehicle' => OutcomingVehicleController::class,
        'round' => RoundController::class,
        'checkpoint-aset' => CheckpointAsetController::class,
        'self-patrol' => SelfPatrolController::class,
        'atensi' => AtensiController::class,
        'checkpoint-report' => CheckpointReportController::class,

    ]);

    //Route
    Route::get('/project-by-wilayah/{id}', [ProjectModelController::class, 'by_wilayah'])->name('project-by-wilayah');
    Route::get('/project-by-wilayah-select/{id}', [ProjectModelController::class, 'by_wilayah_select'])->name('project-by-wilayah-select');
    Route::get('/area-by-project/{id}', [AreaController::class, 'by_project'])->name('area-by-project');

    //Route Data Table
    Route::get('user-datatable', [UserController::class, 'datatable'])->name('user.datatable');
    Route::get('wilayah-datatable', [WilayahController::class, 'datatable'])->name('wilayah.datatable');
    Route::get('area-datatable', [AreaController::class, 'datatable'])->name('area.datatable');
    Route::get('check-point-datatable', [CheckPointController::class, 'datatable'])->name('check-point.datatable');
    Route::get('aset-location-datatable', [AsetLocationController::class, 'datatable'])->name('aset-location.datatable');
    Route::get('ai-master-datatable', [AiMasterDataController::class, 'datatable'])->name('ai-master.datatable');
    Route::get('aset-datatable', [AsetController::class, 'datatable'])->name('aset.datatable');
    Route::get('project-datatable', [ProjectModelController::class, 'datatable'])->name('project.datatable');
    Route::get('aset-location-datatable', [AsetLocationController::class, 'datatable'])->name('aset-location.datatable');
    Route::get('hak-akses-datatable', [HakAksesController::class, 'datatable'])->name('hak-akses.datatable');
    Route::get('user-datatable', [UserController::class, 'datatable'])->name('user.datatable');
    Route::get('check-point-aset.datatable', [CheckpointAsetController::class, 'datatable'])->name('check-point-aset.datatable');
    Route::get('atensi-datatable', [AtensiController::class, 'datatable'])->name('atensi.datatable');
    Route::get('self-patrol-datatable', [SelfPatrolController::class, 'datatable'])->name('self-patrol.datatable');
    Route::get('checkpoint-report-datatable', [CheckpointReportController::class, 'datatable'])->name('checkpoint-report.datatable');
    Route::get('incoming-vehicle.datatable', [IncomingVehicleController::class, 'datatable'])->name('incoming-vehicle.datatable');
    Route::get('outcoming-vehicle.datatable', [OutcomingVehicleController::class, 'datatable'])->name('outcoming-vehicle.datatable');
    

    //Guard
    Route::get('guard-datatable', [GuardController::class, 'datatable'])->name('guard.datatable');

     //Pleton
     Route::get('pleton-datatable', [PletonController::class, 'datatable'])->name('pleton.datatable');

    //Audit Log
    Route::get('audit-log-datatable', [AuditLogController::class, 'datatable'])->name('audit-log.datatable');

    //Ajax hak akses
    Route::post('get-hak-akses', [HakAksesController::class, 'get_hak_akses'])->name('get-hak-akses');



});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';