<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;

Route::post('/getCep', [AjaxController::class, 'getCep'])->name('getCep');
Route::post('/requestReportGroup', [AjaxController::class, 'requestReportGroup'])->name('requestReportGroup');
Route::post('/checkPersonToGroup', [AjaxController::class, 'checkPersonToGroup'])->name('checkPersonToGroup');
Route::post('/unCheckPersonToGroup', [AjaxController::class, 'unCheckPersonToGroup'])->name('unCheckPersonToGroup');
Route::post('/banUser', [AjaxController::class, 'banUser'])->name('banUser');
Route::post('/unBanUser', [AjaxController::class, 'unBanUser'])->name('unBanUser');
