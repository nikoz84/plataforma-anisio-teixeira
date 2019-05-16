<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

/**
 * trait para validar os formulários
 */
trait ValidaForm
{
    public function validar(Request $request, $rules = [])
    {
        $validator = Validator::make($request->all(), $rules);

        return (object)[
            'error' => $validator->fails(),
            'errors' => $validator->errors()
        ];
    }
}
