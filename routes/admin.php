<?php

use App\Http\Controllers\Adm\CompanyController;
use App\Http\Controllers\Adm\PlansController;
use App\Http\Controllers\Adm\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
Route::resource('/company', CompanyController::class)->names('company');
Route::resource('/plan', PlansController::class)->names('plan');
Route::resource('/user', UserController::class)->names('user');
