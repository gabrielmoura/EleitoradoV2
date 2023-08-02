<?php

namespace App\Features;

use App\Models\User;

class Appointment
{
    /**
     * Resolve the feature's initial value.
     */
    public function resolve(User $user): mixed
    {
        return match ($user->company->conf?->get('appointment')) {
            true => true,
            false => false,
            default => false,
        };
        //        return $user->company->conf?->has('appointment') ? $user->company->conf->get('appointment') : false;
    }
}
