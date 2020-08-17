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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $limit = $this->request->get('limit', 15);
        $componentes = CurricularComponent::select("*")->with('niveis')
            ->with("categories")
            ->with("category")
            ->limit($limit)
            ->orderBy('name', 'asc')
            ->paginate($limit);
        return $this->showAsPaginator($componentes);
    }

    /**
     * @param $id
     * @return CurricularComponent
     */
    public function update($id)
    {
        try
        {
            $component = CurricularComponent::find($id);
            $this->authorize('update', $id);
            $validator = Validator::make($this->request->all(), $this->config());
            if ($validator->fails()) {
                throw new Exception('Não foi possível atualizar componente. Erro no preenchimento do formulário.',404);
            }
            
            $component->fill($this->request->all());
            if($component->save())
            {
                throw new Exception('Não foi possível atualizar componente. Tente novamente mais tarde', 501);
            }
        }
        catch(Exception $ex)
        {
            return $this->errorResponse([], $ex->getMessage(), $ex->getCode() > 0 ? $ex->getCode() : 500 );
        }
        return $this->showOne($component, 'Componente Curricular atualizada com sucesso!!', 200);
    }

    /**
     * @param $id
     * @return CurricularComponent
     */
    public function getById($id)
    {
        $component = new Componente();
        try{
            $component =  Componente::findOrFail($id);
            $component->category();
        }
        catch(Exception $ex)
        {
            return $this->errorResponse([], 'Não foi possível deletar a categoria', 422);
        }
        return $component;
    }

    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->rules());
        $data = [];
        
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception("Não foi possível criar componente. Erro no preenchimento do formulário de cadastro.", 501);
            }
            $componente = new Componente();
            $this->authorize('create', JWTAuth::user());   
            $componente->fill($this->request->all());
            if (!$componente->save()) {
                
                throw new Exception('Não foi possível salvar componente', 422);
            }
        }
        catch(Exception $ex)
        {
            return $this->errorResponse($data, $ex->getMessage(), $ex->getCode() > 0 &&  $ex->getCode() <505 ? $ex->getCode() : 500);
        }       
        return $this->successResponse($componente, 'Componente curricular registrada com sucesso!!', 200);
    }

    public function rules()
    {
        return [
            'name'=> 'required|min:2|max:255'
        ];
    }
}
