<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Helpers\GoogleRecaptcha;

class ValidRecaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $recaptcha;

    public function __construct()
    {
        $this->recaptcha = new GoogleRecaptcha;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->recaptcha->validate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Verifique o côdigo de segurança';
    }
}
