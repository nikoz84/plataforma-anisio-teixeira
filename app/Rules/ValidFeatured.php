<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidFeatured implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public bool $nullable = false)
    {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        switch($value) {
            case "null":
                return TRUE;
                break;
            case "false":
                $value = FALSE;
                break;
            case "true":
                $value = TRUE;
                break;
        }
        
        return  filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Campo :attribute requerida.';
    }
}
