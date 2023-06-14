<?php

namespace App\Listeners\Dash\User;

use App\Events\Dash\User\UserUpdatedEvent;
use Illuminate\Support\Facades\Cache;

class UserUpdatedClearPermissionCache
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
    public function handle(UserUpdatedEvent $event): void
    {
        Cache::forget(config('permission.cache.prefix').':roles');
        Cache::forget(config('permission.cache.prefix').':permissions');
    }
}
