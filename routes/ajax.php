<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Dash\CheckinController;
use Illuminate\Support\Facades\Route;

//Route::post('/checkin', [CheckinController::class, 'store'])->name('checkin');
Route::post('/getCep', [AjaxController::class, 'getCep'])->name('getCep');
