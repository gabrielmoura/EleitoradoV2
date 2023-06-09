<?php

namespace App\Service\Trait;

trait PermissionTrait
{
    public function hasRole(string|array $role): bool
    {
        return $this->roles()->where('name', $role)
            ->exists();
    }

    public function hasPermissionTo(string $permission): bool
    {
        return $this->with('roles.permissions', 'permissions')
            ->whereHas('roles.permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })->orWhereHas('permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })->exists();
    }

    public function givePermissionTo(string $permission): void
    {
        $this->permissions()->create(['name' => $permission]);
    }

    public function revokePermissionTo(string $permission): void
    {
        $this->permissions()->where('name', $permission)->delete();
    }

    public function assignRole(string $role): void
    {
        $this->roles()->create(['name' => $role]);
    }

    public function removeRole(string $role): void
    {
        $this->roles()->where('name', $role)->delete();
    }

    public function syncRoles(array $roles): void
    {
        //        $this->roles()->delete();
        foreach ($roles as $role) {
            $this->assignRole($role);
        }
    }

    public function syncPermissions(array $permissions): void
    {
        //        $this->permissions()->delete();
        foreach ($permissions as $permission) {
            $this->givePermissionTo($permission);
        }
    }
}
