<?php

namespace App\Models\Scopes;

use App\Exceptions\TenantException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @throws TenantException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function apply(Builder $builder, Model $model): void
    {
        $tenant_id = session()->get('tenant_id') ?? optional(Auth::user()?->company)->tenant_id;
        if (! $tenant_id) {
            if (! app()->runningInConsole() && ! request()->user()->hasRole('admin')) {
                throw new TenantException(message: 'Tenant id not found', user: auth()->user());
            }
        } else {
            $builder->where('tenant_id', '=', $tenant_id);
        }
    }
}
