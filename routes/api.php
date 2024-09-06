<?php

use App\Http\Controllers\{
    ModeController,
    UserController,
    MonitoringController
};
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::get('/control/{id_device}', [ModeController::class, 'controlPH']);
    Route::post('/send', [MonitoringController::class, 'insertSensor']);
    Route::get('/get-kontrol/', [ModeController::class, 'getKontrol']);
});
