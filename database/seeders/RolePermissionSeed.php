<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Service\Enum\RoleOptions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //'history_', 'restore_'
        $permissions = collect(['person', 'group', 'event', 'demand_type', 'demand', 'user', 'cron'])->map(function ($item) {
            $value = [];
            foreach (['create_', 'update_', 'read_', 'delete_'] as $prefix) {
                $value[] = ['name' => $prefix.$item];
            }

            return $value;
        });
        $permissions->push(['name' => 'send_file']);
        foreach ($permissions as $permission) {
            foreach ($permission as $item) {
                Permission::create($item);
            }
        }
        $roleAdmin = Role::create(['name' => RoleOptions::ADMIN]);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleManager = Role::create(['name' => RoleOptions::MANAGER]);
        $roleManager->givePermissionTo(Permission::all());

        $roleUser = Role::create(['name' => RoleOptions::USER]);
        $roleUser->givePermissionTo(Permission::whereNot('name', 'like', '%delete_%')
            ->whereNot('name', 'like', '%cron%')
            ->whereNot('name', 'like', '%user%')->get());

        Permission::create(['name' => 'invoicing']);

        if (app()->environment('local')) {
            $company = Company::create(['name' => 'Empresa 1', 'email' => 'company@example.com']);
            $adminUser = User::create([
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => 'admin',
            ]);
            $adminUser->assignRole($roleAdmin);

            $managerUser = User::create([
                'name' => 'Gerente',
                'email' => 'manager@example.com',
                'password' => 'manager',
                'company_id' => $company->id,
            ]);
            $managerUser->assignRole($roleManager);
            $managerUser->givePermissionTo(Permission::where('name', 'invoicing')->get());

            $user = User::create([
                'name' => 'Usuário',
                'email' => 'user@example.com',
                'password' => 'user',
                'company_id' => $company->id,
            ]);
            $user->assignRole($roleUser);
        }
    }
}
