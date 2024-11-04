<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordValidation implements Rule
{
    public function passes($attribute, $value)
    {
        $pattern = '/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';
        return preg_match($pattern, $value);
    }

    public function message(): string
    {
        return 'The password must be at least 8 characters long and contain at least one letter, one digit, and one symbol (@$!%*#?&).';
    }
}

