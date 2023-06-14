<?php

//use App\Http\Controllers\Dash\CheckinController;
//use App\Http\Controllers\Dash\CompanyController;
//use App\Http\Controllers\Dash\EventController;
use App\Http\Controllers\Dash\BirthdaysController;
use App\Http\Controllers\Dash\DemandController;
use App\Http\Controllers\Dash\DemandTypeController;
use App\Http\Controllers\Dash\EventController;
use App\Http\Controllers\Dash\GroupController;
use App\Http\Controllers\Dash\HomeController;
use App\Http\Controllers\Dash\PaymentController;
use App\Http\Controllers\Dash\PersonController;
use App\Http\Controllers\Dash\UserController;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\Dash\TagGroupController;
//use App\Http\Controllers\Dash\UserController;

Route::get('/', HomeController::class)->name('index');
Route::resource('/person', PersonController::class)->names('person')->whereUlid('person');

Route::resource('/group', GroupController::class)->only(['index', 'show'])->names('group')->whereUlid('group');
Route::get('/group/{group}/history', [GroupController::class, 'history'])->name('group.history')->whereUlid('group');
Route::resource('/event', EventController::class)->only(['index', 'show'])->names('event')->whereUlid('event');
Route::resource('/demand', DemandController::class)->only(['index', 'show'])->names('demand')->whereUlid('demand');
Route::resource('/demandType', DemandTypeController::class)->only(['index'])->names('demandType')->whereUlid('demandType');
Route::resource('/users', UserController::class)->names('user')->whereNumber('user')->middleware('can:manager');
Route::get('/birthdays', [BirthdaysController::class, 'index'])->name('birthdays');

Route::group(['middleware' => ['can:invoicing'], 'prefix' => 'pay'], function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/planSelected', [PaymentController::class, 'allSubscriptions'])->name('payment.planSelected');
    Route::post('/resume', [PaymentController::class, 'resumeSubscriptions'])->name('payment.resume');
    Route::post('/cancel', [PaymentController::class, 'cancelSubscriptions'])->name('payment.cancel');
    Route::get('/success', [PaymentController::class, 'subscriptionSuccess'])->name('payment.success');

    Route::get('/{plan}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/{plan}/checkout', [PaymentController::class, 'store'])->name('payment.store');

});

//Route::get('/voter/{voter}/history', [PersonController::class, 'history'])->name('voter.history');
//Route::resource('/user', UserController::class)->names('user');
////Route::resource('/event', EventController::class)->names('event');
//Route::resource('/checkin', CheckinController::class)->names('checkin');
//Route::resource('/company', CompanyController::class)->names('company');
//Route::resource('/tag', TagGroupController::class)->names('tag');
//Route::get('/tag/{tag}/history', [TagGroupController::class, 'history'])->name('tag.history');
