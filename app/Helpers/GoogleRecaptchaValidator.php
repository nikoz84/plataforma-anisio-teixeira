<?php
namespace App\Helpers;

use Illuminate\Contracts\Validation\Rule;
use App\Helpers\GoogleRecaptcha;

class GoogleRecaptchaValidator implements Rule
{
    public function passes($attribute, $value)
    {
        $recaptcha = new GoogleRecaptcha($value);

        return $recaptcha->validate();
    }
    public function message()
    {
        return 'código de segurança não válido';
    }
}
