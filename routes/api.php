<?php

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

    Route::post('/authorization', [\App\Http\Controllers\Api\Autorization::class, 'login'])->block();

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

});
Route::post('/info', function () {
    $all = request()->json()->all();
    ds($all);

    return response()->json(['status' => 'ok', 'data' => $all]);
});
