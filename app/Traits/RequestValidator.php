<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

trait RequestValidator
{
    /**
     * Convierte todos los campos con dot notation para un array associativo
     * ex. options.is_active. Também escreve uma mensagem padrão para sobre escrever
     * a mensagem do laravel
     */
    protected function failedValidation(Validator $validator)
    {
        
        $errors = [];
        foreach (collect($validator->errors()) as $key => $value) {
            array_set($errors, $key, $value);
        }
        
        $response = response()->json([
            'message' => 'Não Foi possível realizar essa ação',
            'errors' => $errors,
        ], 422);

        throw new ValidationException($validator, $response);
    }
    /**
     * Transforma o campo JSON.stringify para um array de validações
     */
    protected function getValidatorInstance()
    {
        $json = $this->request->get($this->stringify);
        
        if(!is_null($json)){
        	$this->merge(json_decode($json, true));
        }
        
        return parent::getValidatorInstance();
    }
}
