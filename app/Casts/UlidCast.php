<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;

class UlidCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return Ulid::fromString($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return Str::ulid()->toRfc4122();
    }
}
