<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\CheckinController;
use App\Http\Controllers\AjaxController;

//Route::post('/checkin', [CheckinController::class, 'store'])->name('checkin');
Route::post('/getCep', [AjaxController::class, 'getCep'])->name('getCep');
