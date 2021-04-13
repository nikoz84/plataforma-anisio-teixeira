<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponser;
use App\Models\Conteudo;
use Illuminate\Support\Facades\Auth;

class ConteudoFormRequest extends FormRequest
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
            'options' => [
                'site' => request()->options_site
            ]
        ]);

        if(request()->method() == "POST"){
            $this->whenCreate();
        }
        
        
        return $this->toArray();
    }

    public function withValidator($validator)
    {
        if($validator->fails()){
            $action = request()->method() == "POST" ? "criar" : "atualizar";
            return $this->errorResponse($validator->errors(), "Não foi possível {$action} o conteúdo", 422); 
        }
    }

    public function whenCreate()
    {
        $role_id = Auth::user()->role->id;
        $data = [];
        if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
            $data['approving_user_id'] = Auth::user()->id;
            $data['is_approved'] = request()->is_approved;
            $data['is_featured'] = request()->is_featured;
        } else {
            $data['approving_user_id'] = null;
            $data['is_approved'] = false;
            $data['is_featured'] = false;
        }

        $data['user_id'] = Auth::user()->id;
        $data['qt_downloads'] = Conteudo::INIT_COUNT;
        $data['qt_access'] = Conteudo::INIT_COUNT;
            
        $this->merge($data);
    }

    /**
     * Get the validation rules that apply to the request.
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
            'title' => 'required|min:5|max:120',
            'description' => 'required|min:140|max:5012',
            'options_site' => 'nullable|active_url',
            'tags' => 'required|array|min:3|max:10',
            'componentes' => 'required',
            'authors' => 'required',
            'source' => 'required',
            'terms' => 'required|boolean',
            'is_featured' => 'sometimes|boolean',
            'is_approved' => 'required|boolean',
            'is_site' => 'sometimes|boolean',
            'download' => ["sometimes", "file", new \App\Rules\ValidExtensions(request()->tipo_id)],
            'guias_pedagogicos' => ["sometimes|file|mimes:pdf,doc,docx,epub|max:120000"],
            'imagem_associada' => 'sometimes|image|mimes:jpeg,jpg,webp,png,gif,svg|max:2048',
            'visualizacao' => ["sometimes", "file", new \App\Rules\ValidExtensions(request()->tipo_id)]
        ];
    }

    

    public function messages()
    {
        return [
            'componentes.required' => 'Selecione ao menos 1 componente curricular para este conteúdo'
        ];
    }
}
