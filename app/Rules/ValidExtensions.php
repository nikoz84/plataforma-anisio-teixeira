<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Tipo;

class ValidExtensions implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Tipo $tipo)
    {
        $this->tipo = $tipo;
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
        $formatos = $this->tipo::select("jsonb_array_elements_text(options->'formatos') as formatos")
            ->where('id', $value)
            ->get();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute inválido.';
    }
}
