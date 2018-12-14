<?php

namespace App\Helpers;

use Illuminate\Contracts\Validation\Rule;

class UrlValidator implements Rule
{
    public function passes($attribute, $value)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }
    public function message()
    {
        return ':attribute inválida';
    }
}