<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Service\Enum\RoleOptions;
use Illuminate\Database\Seeder;

class RolePermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'history_', 'restore_'
        $permissions = collect(['person', 'group', 'event', 'demand_type', 'demand', 'user', 'cron'])->map(function ($item) {
            $value = [];
            foreach (['create_', 'update_', 'read_', 'delete_'] as $prefix) {
                $value[] = ['name' => $prefix . $item];
            }

            return $value;
        });
        foreach ($permissions as $permission) {
            foreach ($permission as $item) {
                Permission::create($item);
            }
        }
        $roleAdmin = Role::create(['name' => RoleOptions::ADMIN]);
        $roleAdmin->permissions()->attach(Permission::all());

        $roleManager = Role::create(['name' => RoleOptions::MANAGER]);
        $roleManager->permissions()->attach(
            Permission::all()
        );

        $roleUser = Role::create(['name' => RoleOptions::USER]);
        $roleUser->permissions()->attach(
            Permission::whereNot('name', 'like', '%delete_%')
                ->whereNot('name', 'like', '%cron%')
                ->whereNot('name', 'like', '%user%')->get()
        );

        if (app()->environment('local')) {
            $company = Company::create(['name' => 'Empresa 1', 'email' => 'company@example.com']);
            $user = User::create([
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => 'admin',
                'company_id' => $company->id
            ]);
            $user->assignRole($roleAdmin->id);
        }
    }
}
