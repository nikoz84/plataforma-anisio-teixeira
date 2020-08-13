<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\CurricularComponent as Componente;
use App\CurricularComponent;
use App\CurricularComponentCategory as Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ComponentesController extends ApiController
{
    use ApiResponser;
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search']);
        $this->request = $request;
    }

    /**
     * Mostra toda as informações do Aplicativo no banco de dados.
     *
     * @param \App\Componentes $componentes
     * @param \App\Controller\Api Responser
     * retorna json
     * @return App\Traits\ApiResponse
     */
    public function index()
    {
        $limit = $this->request->get('limit', 15);
        $componentes = CurricularComponent::select("*")->with('niveis')
            ->with("categories")
            ->limit($limit)
            ->orderBy('name', 'asc')
            ->paginate($limit);
        return $this->showAsPaginator($componentes);
    }

    public function create(Componente $componente)
    {
        $validator = Validator::make($this->request->all(), $this->rules());
        $data = [];
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception("Não foi possível criar componente. Erro no preenchimento do formulário de cadastro.", 501);
            }
            $this->authorize('create', JWTAuth::user());   
            if (!$componente->save()) {
                
                throw new Exception('Não foi possível salvar imagem associada', 422);
            }
        }
        catch(Exception $ex)
        {
            return $this->errorResponse($data, $ex->getMessage(), 422);
        }
    }

    public function rules()
    {
        return [
            'name'=> 'required|min:2|max:255'
        ];
    }
}
