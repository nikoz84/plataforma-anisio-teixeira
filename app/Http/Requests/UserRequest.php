<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use App\Traits\RequestValidator;
use Illuminate\Support\Str;

class UserRequest extends FormRequest
{
    use ApiResponser, RequestValidator;
    /** 
     * Variable utilizada no Trait RequestValidator para converter o request JSON.stringify para array
     */
    public $stringify = 'user';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    public function validated()
    {
        return $this->toArray();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|max:60|email',
            'name' => 'required|min:2|max:100',
            'role_id' => 'required',
            'password' => 'sometimes|min:6',
            'arquivoImagem' => 'image|mimes:jpeg,jpg,webp,png|max:2048',
            'options.birthday' => 'nullable|date|date_format:Y-m-d',
            'options.sexo' => 'nullable',
            'options.telefone' => 'nullable',
            'options.is_active' => 'required|boolean',
            'options.neighborhood' => 'nullable'
        ];
    }
    

    public function messages()
    {
        return [
            'options.sexo.required' => 'Campo genero requerido',
            'options.birthday' => 'data de nascimento deve ser uma data no formato Ano-Mes-Dia',
            'options.sexo' => 'genero',
            'options.telefone' => 'telefone',
            'options.is_active' => 'Usuario Activo',
            'options.neighborhood' => 'endereço'
        ];
    }
}
