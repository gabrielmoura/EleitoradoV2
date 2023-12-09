<?php

namespace App\Casts;

use App\Service\Phone;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PhoneCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Phone
    {
        return Phone::from(numberClear($value));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return numberClear($value);
    }
}
