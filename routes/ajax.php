<?php

use App\Http\Controllers\Adm\InviteController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::post('/getCep', [AjaxController::class, 'getCep'])->name('getCep');
Route::post('/requestReportGroup', [AjaxController::class, 'requestReportGroup'])->name('requestReportGroup');
Route::post('/checkPersonToGroup', [AjaxController::class, 'checkPersonToGroup'])->name('checkPersonToGroup');
Route::post('/unCheckPersonToGroup', [AjaxController::class, 'unCheckPersonToGroup'])->name('unCheckPersonToGroup');
Route::post('/banUser', [AjaxController::class, 'banUser'])->name('banUser');
Route::post('/unBanUser', [AjaxController::class, 'unBanUser'])->name('unBanUser');
Route::post('/reqInviteTo', [InviteController::class, 'toAjax'])
    ->middleware('role:admin')->name('reqInviteTo');

Route::delete('/alert/{alert}', [AlertController::class, 'alertDestroy'])->name('alert.destroy');
Route::post('/alert/{alert}', [AlertController::class, 'alertRead'])->name('alert.read');
Route::delete('/message/{message}', [MessageController::class, 'messageDestroy'])->name('message.destroy');
Route::post('/message/{message}', [MessageController::class, 'messageRead'])->name('message.read');
