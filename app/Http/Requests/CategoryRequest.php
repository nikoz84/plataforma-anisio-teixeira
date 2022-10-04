<?php

namespace App\Http\Requests;

use App\Traits\RequestValidator;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    use RequestValidator;

    protected $stringify = 'category';

    /**
     * Determine if the user is authorized to make this request.
     * Determine se o ususário está autorizado a fazer essa solicitação
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    public function withValidator($validator)
    {

        //$data = collect(request()->only(['category', 'image', '_method']));
        //
        //$data->forget(['category', 'video', 'canal']);

    }

    /**
     * Get the validation rules that apply to the request.
     * Obtenha as regras de validação que se aplicam à solicitação
     *
     * @return array
     */
    public function rules()
    {
        return [
            'canal_id' => 'required',
            'parent_id' => 'nullable',
            'name' => 'required|min:2|max:100|string',
            'options.description' => 'required',
            'options.is_featured' => 'required|boolean',
            'options.is_active' => 'required|boolean',
            'image' => 'nullable|sometimes|mimes:jpeg,jpg,webp,png,gif,svg|max:2048',
        ];
    }

    /**
     * Função de mensagens
     *
     * @return  array de strings com validações
     */
    public function messages()
    {
        return [
            'options.description.require' => 'O campo de descrição precisa estar preenchido',
        ];
    }
}