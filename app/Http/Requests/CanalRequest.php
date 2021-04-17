<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class CanalRequest extends FormRequest
{
    use ApiResponser;
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
        $this->merge([
            'options' => json_decode(request()->options, true)
        ]);
        
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
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required',
            'is_active' => 'required|boolean'
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                "Não foi possível criar o canal",
                422
            );
        }
    }
}
