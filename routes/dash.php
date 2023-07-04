<?php

use App\Http\Controllers\Dash\AppointmentController;
use App\Http\Controllers\Dash\BirthdaysController;
use App\Http\Controllers\Dash\CampaignController;
use App\Http\Controllers\Dash\CompanyController;
use App\Http\Controllers\Dash\DemandController;
use App\Http\Controllers\Dash\DemandTypeController;
use App\Http\Controllers\Dash\DirectMailController;
use App\Http\Controllers\Dash\EventController;
use App\Http\Controllers\Dash\Export\PeopleAddressController;
use App\Http\Controllers\Dash\GroupController;
use App\Http\Controllers\Dash\HomeController;
use App\Http\Controllers\Dash\PaymentController;
use App\Http\Controllers\Dash\PersonController;
use App\Http\Controllers\Dash\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('index');

Route::group(['middleware' => ['subscribed']], function () {
    Route::resource('/person', PersonController::class)->names('person')->whereUuid('person');
    Route::get('/person/{person}/history', [PersonController::class, 'history'])->name('person.history')->whereUuid('person');

    Route::resource('/group', GroupController::class)->only(['index', 'show'])->names('group')->whereUuid('group');
    Route::get('/group/{group}/history', [GroupController::class, 'history'])->name('group.history')->whereUuid('group');

    Route::resource('/event', EventController::class)->only(['index', 'show'])->names('event')->whereUuid('event');
    Route::get('/event/{event}/history', [EventController::class, 'history'])->name('event.history')->whereUuid('event');

    Route::resource('/demand', DemandController::class)->only(['index', 'show'])->names('demand')->whereUuid('demand');
    Route::get('/demand/{demand}/history', [DemandController::class, 'history'])->name('demand.history')->whereUuid('demand');

    Route::resource('/demandType', DemandTypeController::class)->only(['index', 'show'])->names('demandType')->whereUuid('demandType');
    Route::get('/demandType/{demandType}/history', [DemandTypeController::class, 'history'])->name('demandType.history')->whereUuid('demandType');

    Route::resource('/users', UserController::class)->names('user')->whereNumber('user')->middleware('role:manager');
    Route::get('/birthdays', [BirthdaysController::class, 'index'])->name('birthdays');

    /** Exportações */
    Route::get('/exportGroup/{id}', [PeopleAddressController::class, 'response'])->name('reportGroup.get');

    /** Funcionalidades */
    Route::resource('/appointment', AppointmentController::class)
        ->only('index', 'show', 'destroy')
        ->names('appointment')
        ->whereUuid('appointment');
    Route::get('/appointment/ajax', [AppointmentController::class, 'ajax'])
        ->name('appointment.ajax')->middleware('cache.headers:private;max_age=2592000;etag');

    Route::resource('/campaign', CampaignController::class)->names('campaign')->whereUuid('campaign');
    Route::resource('/directMail', DirectMailController::class)->names('directMail')->whereUuid('directMail');
});

Route::group(['middleware' => ['can:invoicing'], 'prefix' => 'subscription', 'as' => 'payment.'], function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('/planSelected', [PaymentController::class, 'allSubscriptions'])->name('planSelected');
    Route::post('/resume', [PaymentController::class, 'resumeSubscriptions'])->name('resume');
    Route::post('/cancel', [PaymentController::class, 'cancelSubscriptions'])->name('cancel');
    Route::get('/success', [PaymentController::class, 'subscriptionSuccess'])->name('success');

    Route::get('/invoices', [PaymentController::class, 'allInvoices'])->name('allInvoices');

    Route::get('/{plan}', [PaymentController::class, 'show'])->name('show');
    Route::post('/{plan}/checkout', [PaymentController::class, 'store'])->name('store');
});
Route::resource('/company', CompanyController::class)->only(['index', 'edit', 'update'])
    ->names('company')->middleware('role:manager');

Route::get('/invoice/preview', function () {
    $user = Auth::user()->company; // fetch the authenticated user

    $invoice = $user->invoices()->first(); // get the first invoice

    if ($invoice) {
        return $invoice->download([
            'vendor' => config('cashier.vendor.name'),
            'product' => config('app.name'),
            'street' => config('cashier.vendor.street'),
            //                    'location' => '2000 Antwerp, Belgium',
            'phone' => config('cashier.vendor.phone'),
            'email' => config('mail.to.address'),
            'url' => config('cashier.vendor.url'),
            'vendorVat' => config('cashier.vendor.document'),
        ]);
    }

    return new Response('No invoice found', 404);
});
