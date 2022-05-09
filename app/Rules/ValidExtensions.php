<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Tipo;
use Illuminate\Support\Facades\DB;

class ValidExtensions implements Rule
{
    private $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->id) {
            return false;
        }

        $tipo = Tipo::where('id', $this->id)->get()->first();

        if (!$tipo) {
            return false;
        }

        $exists = in_array(
            $value->getClientOriginalExtension(), 
            $tipo->options['formatos'] 
        );

        return $exists;
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
