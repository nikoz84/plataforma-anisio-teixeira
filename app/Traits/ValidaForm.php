<?php 

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
/**
 * trait para validar os formulários
 */
trait ValidaForm
{
    use ApiResponser {
            ApiResponser::successResponse as private success; 
        }
    
    public function validar(Request $request, $rules  = [])
    {
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            $errors  = $validator->errors();
            $message = 'Não foi possível efetuar o cadastro';
            $this->errorResponse($errors, $message, 422);
        }
        
    }
}
