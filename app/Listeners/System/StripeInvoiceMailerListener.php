<?php

namespace App\Listeners\System;

use App\Mail\System\InvoiceFinalizedMail;
use App\Models\Company;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;

class StripeInvoiceMailerListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'invoice.finalized') {
            // Let's find the relevant user/billable
            $stripeCustomerId = $event->payload['data']['object']['customer'];
            $billable = Cashier::findBillable($stripeCustomerId);

            // Get the Laravel\Cashier\Invoice object
            $invoice = $billable->findInvoice($event->payload['data']['object']['id']);
            $company = Company::whereStripeId($stripeCustomerId)->first();

            // Now we can send the invoice!
            Mail::to($billable)->queue(new InvoiceFinalizedMail($invoice, $company));
        }
    }
}
