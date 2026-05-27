<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoAllCaps implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === strtoupper($value) && strlen($value) > 3) {
            $fail("The :attribute should not be written in all capitals.");
        }
    }
}
