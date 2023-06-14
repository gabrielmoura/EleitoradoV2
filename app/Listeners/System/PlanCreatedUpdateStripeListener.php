<?php

namespace App\Listeners\System;

use App\Events\System\PlanCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;

class PlanCreatedUpdateStripeListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @throws ApiErrorException
     */
    public function handle(PlanCreated $event): void
    {
        $plan = Cashier::stripe()->plans->create([
            'amount' => $event->plan->price,
            'interval' => $event->plan->billing_period,
            'product' => [
                'name' => $event->plan->name,
            ],
            'currency' => $event->plan->currency,
            'id' => $event->plan->name,
        ]
        );
        $event->plan->update(['plan_id' => $plan->id]);
    }
}
