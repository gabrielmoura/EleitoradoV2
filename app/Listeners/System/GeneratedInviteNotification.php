<?php

namespace App\Listeners\System;

use App\Events\System\GeneratedInviteEvent;
use App\Mail\System\InvitedMail;
use Illuminate\Support\Facades\Mail;

class GeneratedInviteNotification
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
    public function handle(GeneratedInviteEvent $event): void
    {
        Mail::to($event->email)
            ->queue(
                new InvitedMail(
                    url: $event->url,
                    email: $event->email,
                    role: $event->role,
                    company_id: $event->company_id,
                    tenant_id: $event->tenant_id,
                    expiration: $event->expiration
                )
            );
    }
}
