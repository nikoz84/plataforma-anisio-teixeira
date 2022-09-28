<?php

namespace App\Http\Requests;

use App\Models\Conteudo;
use App\Rules\ConteudoTitleExist;
use App\Rules\ValidExtensions;
use App\Traits\RequestValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConteudoFormRequest extends FormRequest
{
    use RequestValidator;

    protected $stringify = 'conteudo';

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

    public function withValidator($validator)
    {
        //dd($validator->valid());
    }

    /**
     * Função de Validação
     *
     * @param void
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        if (request()->method() == 'POST') {
            $this->whenCreate();
        }

        return $this->toArray();
    }

    /**
     * Método de Nome Quando criar
     *
     * @return array
     */
    public function whenCreate()
    {
        $data = collect($this->toArray());
        $role_id = Auth::user()->role->id;

        if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
            $data->put('approving_user_id', Auth::user()->id);
            $data->put('is_approved', $data->get('is_approved'));
            $data->put('is_featured', $data->get('is_featured'));
        } else {
            $data->put('approving_user_id', null);
            $data->put('is_approved', false);
            $data->put('is_featured', false);
        }

        $data->put('user_id', Auth::user()->id);
        $data->put('qt_downloads', Conteudo::INIT_COUNT);
        $data->put('qt_access', Conteudo::INIT_COUNT);
        //dd($data);
        $data->forget('conteudo');

        $this->merge($data->toArray());
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
            'license_id' => 'required',
            'canal_id' => 'required',
            'tipo_id' => 'required',
            'category_id' => 'nullable',
            'title' => ['required', 'min:5', 'max:200', new ConteudoTitleExist],
            'description' => 'required|min:100|max:5012',
            'options.site' => 'nullable|active_url',
            'tags' => 'required|array|min:3|max:50',
            'componentes' => 'required|array|min:1',
            'authors' => 'required',
            'source' => 'required',
            'terms' => 'required|boolean',
            'is_featured' => 'sometimes|boolean',
            'is_approved' => 'required|boolean',
            'is_site' => 'sometimes|boolean',
            'download' => ['sometimes', 'file', new ValidExtensions($this->get('tipo_id'))],
            'guias_pedagogicos' => ["sometimes','file','mimes:pdf,doc,docx,epub','max:120000"],
            'imagem_associada' => ['sometimes', 'image', 'mimes:jpeg,jpg,webp,png,gif,svg', 'max:2048'],
            'visualizacao' => ['sometimes', 'file', new ValidExtensions($this->get('tipo_id'))],
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
            'exists' => 'Esse título existe.',
            'options.site.active_url' => 'O campo URL do Site não é uma URL válida',
            'componentes.required' => 'Selecione ao menos 1 componente curricular para este conteúdo',
        ];
    }
}