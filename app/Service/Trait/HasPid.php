<?php

namespace App\Service\Trait;

use Illuminate\Support\Str;

trait HasPid
{
    public function getRouteKeyName(): string
    {
        return 'pid';
    }

    //bootHasPid
    protected static function bootHasPid(): void
    {
        static::creating(function ($model) {
            $model->pid = Str::ulid()->toRfc4122();
        });
    }
}
