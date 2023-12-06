<?php

namespace App\Listeners\Demand;

use App\Events\Demand\DemandCreatedEvent;
use Illuminate\Support\Facades\Mail;

class DemandCreatedMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DemandCreatedEvent $event): void
    {
        $responsible = $event->demand->type()->first()->responsible;
        if ($responsible !== null) {
            Mail::to($responsible)
                ->queue(new \App\Mail\Dash\DemandCreatedMail($event->demand));
        }
    }
}
