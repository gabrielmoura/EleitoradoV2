<?php

use App\Events\Export\PDF\ExportedPeopleAddress;
use App\Events\Export\PDF\FailedExportPeopleAddress;
use App\Jobs\Export\PDF\ExportPeopleAddressJob;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/get/{id}', [\App\Http\Controllers\Dash\Export\PeopleAddressController::class, 'response'])->name('getFile');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
//    'hasCompany'
])->prefix('dash')->name('dash.')->group(fn() => require_once 'dash.php');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('admin')->name('admin.')->group(fn() => require_once 'admin.php');

Route::middleware([
    'auth',
    'ajaxOnly'
])->prefix('ajax')->name('ajax.')->group(fn() => require_once 'ajax.php');
