<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'guard_name'];

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'permission_user');
    }

    protected static function boot(): void
    {
        parent::boot();
        static::created(function ($model) {
            app()['cache']->forget(config('permission.cache.prefix'));
        });
        static::updated(function ($model) {
            app()['cache']->forget(config('permission.cache.prefix'));
        });
    }
}
