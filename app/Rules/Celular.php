<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Celular implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^\d{4,5}-\d{4}$/', $value)) {
            $fail('O campo :attribute não é um celular válido.');
        }
    }
}
