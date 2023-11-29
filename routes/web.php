<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\Auth\InviteController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
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
Route::group(['middleware' => 'cache.headers:public;max_age=2592000;etag', 'as' => 'front.'], function () {
    Route::get('/', [FrontController::class, 'index'])->name('index');
    Route::get('/privacy', [FrontController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [FrontController::class, 'terms'])->name('terms');
    Route::get('/pricing', [FrontController::class, 'pricing'])->name('pricing');
    Route::get('/faq', [FrontController::class, 'faq'])->name('faq');
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::resource('/invite', InviteController::class)->only(['index', 'store'])->names('invite');
    Route::get('/redirect/{provider}', [SocialController::class, 'redirect'])->name('social.redirect');
    Route::get('/callback/{provider}', [SocialController::class, 'callback'])->name('social.callback');
});

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('alerts', [AlertController::class, 'notifications'])->name('user.alert');
    Route::get('/alerts/all', [AlertController::class, 'notificationAll'])->name('user.alert.all');
    Route::get('/alerts/{notification}', [AlertController::class, 'notificationShow'])
        ->whereUuid('notification')->name('user.alert.show');

    Route::get('messages', [MessageController::class, 'notifications'])->name('user.message');
    Route::get('/messages/{notification}', [MessageController::class, 'notificationShow'])->name('user.message.show');
});

Route::group(['prefix' => 'webhook', 'name' => 'webhook.'], function () {
    // Use queue to process webhooks
    //    Route::post('/stripe', [WebhookController::class, 'stripe'])->name('stripe');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', HomeController::class)->name('dashboard');
    Route::mediaLibrary();
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    //    'hasCompany'
])->prefix('dash')->name('dash.')->group(fn () => require_once 'dash.php');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('admin')->name('admin.')->group(fn () => require_once 'admin.php');

Route::middleware([
    'auth',
    'ajaxOnly',
])->prefix('ajax')->name('ajax.')->group(fn () => require_once 'ajax.php');
