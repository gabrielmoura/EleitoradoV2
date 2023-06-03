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

        try {
            if (Cache::has(config('permission.cache.prefix') . 'roles') && Cache::has(config('permission.cache.prefix') . 'permissions')) {
                $rolesArray = Cache::get(config('permission.cache.prefix') . 'roles');
                $permissionsArray = Cache::get(config('permission.cache.prefix') . 'permissions');
            } else {
                $roles = Role::all();
                $users = User::all();
                $permissions = Permission::all();

                $rolesArray = [];
                $permissionsArray = [];

                foreach ($users as $user) {
                    foreach ($permissions as $permission) {
                        $permissionsArray[$permission->name][] = $user->hasPermissionTo($permission->name) ? $user->id : null;
                    }
                    foreach ($roles as $role) {
                        $rolesArray[$role->name][] = $user->hasRole($role->name) ? $user->id : null;
                    }
                }
                Cache::set(config('permission.cache.prefix') . 'permissions', $permissionsArray, config('permission.cache.ttl'));
                Cache::set(config('permission.cache.prefix') . 'roles', $rolesArray, config('permission.cache.ttl'));
            }


            foreach ($permissionsArray as $permission => $users) {
                Gate::define($permission, function ($user) use ($users) {
                    return in_array($user->id, $users);
                });
            }
            foreach ($rolesArray as $role => $users) {
                Gate::define($role, function ($user) use ($users) {
                    return in_array($user->id, $users);
                });
            }

        } catch (\Exception $e) {
//            dd($e);
        }

    }
}
