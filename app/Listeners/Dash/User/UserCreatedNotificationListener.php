<?php

namespace App\Listeners\Dash\User;

use App\Events\Dash\User\UserCreatedEvent;
use App\Mail\Dash\WelcomeCompanyMail;
use Illuminate\Support\Facades\Mail;

class UserCreatedNotificationListener
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
    public function handle(UserCreatedEvent $event): void
    {
        Mail::to($event->user)
            ->queue(new WelcomeCompanyMail($event->user->company()->first()->name, $event->user, $event->password));
    }
}
