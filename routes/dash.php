<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Dash\{
    HomeController,
    PersonController,
    UserController,
    EventController,
    CheckinController,
    CompanyController,
    TagGroupController,
    GroupController
};

Route::get('/', HomeController::class)->name('index');
Route::resource('/person', PersonController::class)->names('person')->whereUlid('person');

Route::resource('/group',GroupController::class)->only(['index','show'])->names('group');
Route::get('/group/{group}/history', [GroupController::class, 'history'])->name('group.history')->whereUlid('group');
Route::get('/event', \App\Http\Livewire\Event\Index::class)->name('event');
Route::get('/demand', \App\Http\Livewire\Demand\Index::class)->name('demand');

//Route::get('/voter/{voter}/history', [PersonController::class, 'history'])->name('voter.history');
//Route::resource('/user', UserController::class)->names('user');
////Route::resource('/event', EventController::class)->names('event');
//Route::resource('/checkin', CheckinController::class)->names('checkin');
//Route::resource('/company', CompanyController::class)->names('company');
//Route::resource('/tag', TagGroupController::class)->names('tag');
//Route::get('/tag/{tag}/history', [TagGroupController::class, 'history'])->name('tag.history');



