<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AtensiController;
use App\Http\Controllers\SelfPatrolController;
use App\Models\SelfPatrol;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login'])->name('login.api');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('me',[AuthController::class,'me'])->name('me.api');
    Route::post('self-patrol', [SelfPatrolController::class, 'store'])->name('self-patrol.store');
    Route::post('atensi', [AtensiController::class, 'store'])->name('atensi.store');
    Route::get('atensi-all', [AtensiController::class, 'all_data'])->name('atensi.all');
    Route::get('atensi/{id_user}', [AtensiController::class, 'data_per_user'])->name('atensi.per.user');
});