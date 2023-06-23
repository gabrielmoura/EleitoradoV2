<?php

use App\Http\Controllers\Dash\BirthdaysController;
use App\Http\Controllers\Dash\CompanyController;
use App\Http\Controllers\Dash\DemandController;
use App\Http\Controllers\Dash\DemandTypeController;
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

    Route::resource('/group', GroupController::class)->only(['index', 'show'])->names('group')->whereUuid('group');
    Route::get('/group/{group}/history', [GroupController::class, 'history'])->name('group.history')->whereUuid('group');
    Route::resource('/event', EventController::class)->only(['index', 'show'])->names('event')->whereUuid('event');
    Route::resource('/demand', DemandController::class)->only(['index', 'show'])->names('demand')->whereUuid('demand');
    Route::resource('/demandType', DemandTypeController::class)->only(['index', 'show'])->names('demandType')->whereUuid('demandType');
    Route::resource('/users', UserController::class)->names('user')->whereNumber('user')->middleware('role:manager');
    Route::get('/birthdays', [BirthdaysController::class, 'index'])->name('birthdays');

    /** Exportações */
    Route::get('/get/{id}', [PeopleAddressController::class, 'response'])->name('getFile');

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
Route::resource('/testa', \App\Http\Controllers\Dash\AppointmentController::class)->names('appointment');
