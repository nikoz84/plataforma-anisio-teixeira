<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Tipo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ValidExtensions implements Rule
{
    private $tipo_id = null;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->tipo_id = $request->tipo_id;
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
        $tipo = Tipo::where('id', $this->tipo_id)->get()->first();
        
        $exists = in_array($value->getClientOriginalExtension(), $tipo->options['formatos']);
        
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
