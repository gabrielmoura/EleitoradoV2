<?php

use App\Http\Controllers\Auth\InviteController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
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
