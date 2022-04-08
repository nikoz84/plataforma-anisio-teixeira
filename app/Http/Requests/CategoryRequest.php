<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestValidator;

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
            'featured_image' => 'sometimes|mimes:jpeg,jpg,webp,png,gif,svg|max:2048'
        ];
    }

   
}
