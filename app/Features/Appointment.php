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
        return $user->company->conf?->has('appointment') ? $user->company->conf->get('appointment') : false;
    }
}
