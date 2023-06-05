<?php

namespace App\Listeners\Demand;

use App\Events\Demand\DemandClosedEvent;

class DemandClosedMail
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
    public function handle(DemandClosedEvent $event): void
    {
        //
    }
}
