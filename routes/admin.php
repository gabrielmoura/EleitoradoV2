<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Adm\PermissionController;
use App\Http\Controllers\Adm\{
    UserController,
    CompanyController
};

Route::get('/', function () {
    $user = \App\Models\User::find(1);
    return view('dashboard', compact('user'));
})->name('dashboard');
//Route::resource('/role', PermissionController::class)->names('role');
//Route::resource('/user', UserController::class)->names('user');
//Route::resource('/company', CompanyController::class)->names('company');
