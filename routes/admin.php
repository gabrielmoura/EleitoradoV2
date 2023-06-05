<?php

use App\Http\Controllers\Adm\CompanyController;
use App\Http\Controllers\Adm\PermissionController;
use App\Http\Controllers\Adm\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = \App\Models\User::find(1);

    return view('dashboard', compact('user'));
})->name('dashboard');
//Route::resource('/role', PermissionController::class)->names('role');
//Route::resource('/user', UserController::class)->names('user');
//Route::resource('/company', CompanyController::class)->names('company');
