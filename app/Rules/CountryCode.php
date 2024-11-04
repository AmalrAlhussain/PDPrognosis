<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;

class CountryCode implements Rule
{
    protected $validCountries = [];

    public function __construct()
    {
        $this->loadCountries();
    }

    protected function loadCountries()
    {
        $countriesFilePath = config_path('countries.json');
        if (File::exists($countriesFilePath)) {
            $countries = json_decode(File::get($countriesFilePath), true);
            $this->validCountries = array_column($countries, 'code');
        }
    }

    public function passes($attribute, $value)
    {
        return in_array($value, $this->validCountries);
    }

    public function message()
    {
        return __('The selected country is invalid.');
    }
}
