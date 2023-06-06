<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (User $user, string $ability, $arguments) {
            if (! config('permission.cache.enabled')) {
                return $user->hasPermissionTo($ability) || $user->hasRole('admin');
            } else {
                if (Cache::has(config('permission.cache.prefix').'roles') && Cache::has(config('permission.cache.prefix').'permissions')) {
                    // Com Cache
                    $rolesArray = Cache::get(config('permission.cache.prefix').'roles');
                    $permissionsArray = Cache::get(config('permission.cache.prefix').'permissions');
                } else {
                    // Sem Cache
                    $roles = Role::all();
                    $users = User::all();
                    $permissions = Permission::all();
                    $rolesArray = [];
                    $permissionsArray = [];
                    foreach ($users as $userx) {
                        foreach ($permissions as $permission) {
                            $permissionsArray[$permission->name][] = $userx->hasPermissionTo($permission->name) ? $userx->id : null;
                        }
                        foreach ($roles as $role) {
                            $rolesArray[$role->name][] = $userx->hasRole($role->name) ? $userx->id : null;
                        }
                    }
                    Cache::set(config('permission.cache.prefix').'permissions', $permissionsArray, config('permission.cache.ttl'));
                    Cache::set(config('permission.cache.prefix').'roles', $rolesArray, config('permission.cache.ttl'));
                }

                return in_array($user->id, $permissionsArray[$ability] ?? [])
                    || in_array($user->id, $rolesArray[$ability] ?? [])
                    || $user->hasRole($ability);
            }
        });

    }
}
