<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponser;
use App\Models\Aplicativo;
use Illuminate\Support\Facades\Auth;
use App\Traits\RequestValidator;
class AplicativoRequest extends FormRequest
{
    use RequestValidator;
    protected $stringify = 'aplicativo';
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
      * @param void
      * @return array
      */
    public function validated($key = null, $default = null)
    {
        if(request()->method() == 'POST') {
            return $this->whenCreated();
        }
        return $this->toArray();
    }
      /**
       * @param void
       * @return array
       */
    public function whenCreated()
    {
        $data = collect($this->toArray());
        
        $data->put('user_id', Auth::user()->id);
        $data->put('canal_id', Aplicativo::CANAL_ID);
        $options = collect($data->get('options'));
        $options->put('qt_access', Aplicativo::QT_ACCESS_INIT);
        $data->put('options' , $options->toArray());
        $data->forget('aplicativo');

        return $data->toArray();
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
            'name' => 'required|min:2|max:255',
            'description' => 'required|min:140',
            'category_id' => 'required',
            'url' => 'required|active_url',
            'options.is_featured' => 'sometimes|boolean',
            'tags' => 'required|array|min:3|max:15',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,svg|max:1024'
        ];
    }
    /*
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            $action = request()->method() == "POST" ? "criar" : "atualizar";
            return $this->errorResponse($validator->errors(), "Não foi possível {$action} o aplicativo", 422);
        }
    }
    */
}
