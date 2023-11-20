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
        $eventType = $event->payload['type'];

        if (in_array($eventType, ['invoice.finalized', 'invoice.payment_succeeded'])) {
            $stripeCustomerId = $event->payload['data']['object']['customer'];
            $billable = Cashier::findBillable($stripeCustomerId);

            if ($billable) {
                $invoiceId = $event->payload['data']['object']['id'];
                $invoice = $billable->findInvoice($invoiceId);
                $company = Company::whereStripeId($stripeCustomerId)->first();

                if ($invoice && $company) {
                    Mail::to($billable)->queue(new InvoiceFinalizedMail($invoice, $company));
                }
            }
        }
    }
}
