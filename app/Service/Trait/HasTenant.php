<?php

namespace App\Service\Trait;

use App\Models\Scopes\TenantScope;

trait HasTenant
{
    protected static function bootHasTenant(): void
    {
        static::creating(function ($model) {
            if (! app()->runningInConsole()) {
                $model->tenant_id = session()->get('tenant_id');
            }
        });
        static::addGlobalScope(new TenantScope);
    }
}
