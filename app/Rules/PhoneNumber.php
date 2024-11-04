<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    public function passes($attribute, $value)
    {
        $pattern = '/^(?:\+?966)?05\d{8}$/';
        return preg_match($pattern, $value);
    }

    public function message(): string
    {
        return 'The phone number must be starting with +96605 or 05 followed by 8 digits.';
    }
}
