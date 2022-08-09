<?php

namespace App\Http\Requests;

use App\Traits\ApiResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CanalRequest extends FormRequest
{
    use ApiResponser;

    /**
     * Determine if the user is authorized to make this request.
     * Determine se o usuário está autorizado a fazer essa solicitação
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Método qeu faz a validação
     *
     *@param void
     *@return array
     */
    public function validated()
    {
        $this->merge([
            'options' => json_decode(request()->options, true),
        ]);

        return $this->toArray();
    }

    /**
     * Get the validation rules that apply to the request.
     * Obtenha as regras de Validação que se aplicam à solicitação
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required',
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Método com validador
     *
     * @param  mixed  $validador
     * @return error response com código do protocolo http
     */
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                'Não foi possível criar o canal',
                422
            );
        }
    }
}
