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
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    
    /**
     * Get the validation rules that apply to the request.
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
