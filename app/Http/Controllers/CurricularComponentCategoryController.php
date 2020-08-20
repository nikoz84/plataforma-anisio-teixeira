<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\CurricularComponent as Componente;
use App\CurricularComponent;
use App\CurricularComponentCategory as Category;
use App\CurricularComponentCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class CurricularComponentCategoryController extends ApiController
{
    use ApiResponser;
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search']);
        $this->request = $request;
    }

    /**
     * @param $id
     * @return CurricularComponentCategory
     */
    public function update($id)
    {
        try
        {
            $data = [];
            $componentCategory = CurricularComponentCategory::find($id);
            $validator = Validator::make($this->request->all(), $this->rules());
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception('Não foi possível atualizar a categoria do componente. Erro no preenchimento do formulário.',404);
            }           
            $componentCategory->fill($this->request->all());
            //$componentCategory->componentes()->updateOrCreate($this->request->componentes);
            if(!$componentCategory->save())
            {
                throw new Exception('Não foi possível atualizar a categoria do componente. Tente novamente mais tarde', 501);
            }
        }
        catch(Exception $ex)
        {
            return $this->errorResponse($data, $ex->getMessage(), $ex->getCode() > 0  && $ex->getCode() < 506 ? $ex->getCode() : 500 );
        }
        return $this->showOne($componentCategory, 'Componente Curricular atualizada com sucesso!!', 200);
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
            $componente = new CurricularComponentCategory();
            $this->authorize('create', JWTAuth::user());   
            $componente->fill($this->request->all());
            if (!$componente->save()) {
                
                throw new Exception('Não foi possível salvar categoria do componente', 422);
            }
        }
        catch(Exception $ex)
        {
            return $this->errorResponse($data, $ex->getMessage(), $ex->getCode() > 0 &&  $ex->getCode() <505 ? $ex->getCode() : 500);
        }       
        return $this->successResponse($componente, 'Categoria do Componente curricular registrada com sucesso!!', 200);
    }

    /**
     * @return \Iluminate\Http\JsonResponse
     */
    public function index()
    {
        $limit = $this->request->get('limit', 15);
        $componentesCategoria = CurricularComponentCategory::select("*")
            ->limit($limit)
            ->orderBy('name', 'asc')
            ->paginate($limit);
        return $this->showAsPaginator($componentesCategoria);
    }

    public function search($termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 20;
        $search = "%{$termo}%";
        $paginator = CurricularComponentCategory::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])
            ->paginate($limit);
        $paginator->setPath("/componentescategorias/search/{$termo}?limit={$limit}");
        return $this->showAsPaginator($paginator, 'Resultado da busca...', 200);
    }

    

    public function getById($id)
    {
        $componentesCategoria = new CurricularComponentCategory();
        try
        {
            $componentesCategoria = CurricularComponentCategory::findOrFail($id);
            $componentesCategoria->componentes;
        }
        catch(Exception $ex)
        {

        }
        return $componentesCategoria;
    }

    /**
     * Deleta o aplicativo no banco de dados
     * @param int $id identificador único
     * @return \App\Controller\ApiResponser
     * retorna Json
     */
    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        try{
            if ($validator->fails()) {
                $data = $validator->errors();
                return $this->errorResponse($validator->errors(), "Não foi possível deletar.", 201);
            }
            $category = CurricularComponentCategory::findOrFail($id);
            $this->authorize('delete', $category);
            if (!$category->delete()) {
               throw new Exception("Erro ao deletar a categoria: ".$category->name." Tente novamente em seguida.");
            }
        }
        catch(Exception $ex)
        {
            return $this->errorResponse([], $ex->getMessage(), $ex->getCode() > 0 &&  $ex->getCode() <505 ? $ex->getCode() : 500);
        }
        return $this->successResponse($category, 'Categoria do componente deletada com sucesso!', 200);
    }

    public function rules()
    {
        return [
            'name'=> 'required|min:2|max:255'
        ];
    }
}