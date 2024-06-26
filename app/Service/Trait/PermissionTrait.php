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
        return $this->permissions()->where('name', $permission)
            ->exists() || $this->roles()->whereHas('permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })->exists();
        // is equal to user
    }

    public function givePermissionTo(int $permission): void
    {
        //        $this->permissions()->create(['name' => $permission]);
        $this->permissions()->attach($permission);
    }

    public function revokePermissionTo(string $permission): void
    {
        $this->permissions()->where('name', $permission)->delete();
    }

    public function assignRole(int $role): void
    {
        $this->roles()->attach($role);
    }

    public function removeRole(string $role): void
    {
        $this->roles()->where('name', $role)->delete();
    }

    public function syncRoles(array $roles): void
    {
        $this->roles()->detach();
        foreach ($roles as $role) {
            $this->assignRole($role);
        }
    }

    public function syncPermissions(array $permissions): void
    {
        $this->permissions()->detach();
        foreach ($permissions as $permission) {
            $this->givePermissionTo($permission);
        }
    }
}
