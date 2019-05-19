<?php

namespace App\Helpers;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FormValidation 
{
    //use ApiResponser { ApiResponser::errorResponse as response }

    public static function validarFormulario(Request $request, $rules = [])
    {
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $self->response($validator->errors(), "Verifique os dados fornecidos", 201);
            return false;
        }else{
            return true;
        }

    }
}