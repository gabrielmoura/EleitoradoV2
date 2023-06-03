<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'history_', 'restore_'
        $permissions = collect(['person', 'group', 'event'])->map(function ($item) {
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
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->permissions()->attach(Permission::all());

        $roleUser = Role::create(['name' => 'user']);
        $roleUser->permissions()->attach(
            Permission::whereNot('name', 'like', '%delete_%')->get()
        );
    }
}
