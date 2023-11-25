<?php

use App\Http\Controllers\Api\Autorization;
use App\Http\Controllers\Api\Dash\AppointmentController;
use App\Http\Controllers\Api\Dash\EventController;
use App\Http\Controllers\Api\Dash\GroupController;
use App\Http\Controllers\Api\Dash\PersonController;
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

Route::prefix('v1')->group(function () {

    Route::post('/authorization', [Autorization::class, 'login'])->block();

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    /** Rotas Protegidas */
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('person', PersonController::class);
        Route::apiResource('event', EventController::class);
        Route::apiResource('group', GroupController::class);
        Route::apiResource('appointment', AppointmentController::class);
    });
});
Route::post('/eco', function () {
    $all = request()->json()->all();

    return response()->json(['status' => 'ok', 'data' => $all]);
});
