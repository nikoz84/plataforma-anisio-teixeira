<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponser;
use App\Models\Aplicativo;
use Illuminate\Support\Facades\Auth;

class AplicativoRequest extends FormRequest
{
    use ApiResponser;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validated()
    {
        $this->merge([
            'canal_id' => Aplicativo::CANAL_ID,
            'options' => json_decode(request()->options, true)
        ]);

        if(request()->method() == 'POST') {
            $this->whenCreated();
        }
        return $this->toArray();
    }

    public function whenCreated()
    {
        $this->append([
            'user_id' => Auth::user()->id,
            'options' => [
                'is_featured' => request()->is_featured,
                'qt_access' => Aplicativo::QT_ACCESS_INIT
            ]
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'description' => 'required|min:140',
            'category_id' => 'required',
            'url' => 'required|active_url',
            'options_is_featured' => 'sometimes|boolean',
            'tags' => 'required|array|min:3|max:10',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,svg|max:1024'
        ];
    }
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            $action = request()->method() == "POST" ? "criar" : "atualizar";
            return $this->errorResponse($validator->errors(), "Não foi possível {$action} o aplicativo", 422);
        }
    }
}
