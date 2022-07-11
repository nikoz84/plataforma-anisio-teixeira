<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\CurricularComponentCategory;
use App\Helpers\CachingModelObjects;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class CurricularComponentCategoryController extends ApiController
{
    use ApiResponser;
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search', 'getById']);
        $this->request = $request;
    }

    /**
     * Atualiza o Componente curricular no banco de dados
     * @param $id integer Identificador único
     * @return CurricularComponentCategory
     * @return string - json
     */
    public function update($id)
    {
        try {
            $data = [];
            $componentCategory = CurricularComponentCategory::find($id);
            $validator = Validator::make($this->request->all(), $this->rules());
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception(
                    'Não foi possível atualizar a categoria do componente. Erro no preenchimento do formulário.',
                    422
                );
            }
            $componentCategory->fill($this->request->all());
            //$componentCategory->componentes()->updateOrCreate($this->request->componentes);
            if (!$componentCategory->save()) {
                throw new Exception(
                    'Não foi possível atualizar a categoria do componente. Tente novamente mais tarde',
                    422
                );
            }
        } catch (Exception $ex) {
            return $this->errorResponse(
                $data,
                $ex->getMessage(),
                $ex->getCode() > 0  && $ex->getCode() < 506 ? $ex->getCode() : 500
            );
        }
        return $this->showOne($componentCategory, 'Componente Curricular atualizada com sucesso!!', 200);
    }
    /**
     * Cria e Valida o Componente Curricular
     * @return string - json
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->rules());
        $data = [];

        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception(
                    "Não foi possível criar componente. Erro no preenchimento do formulário de cadastro.",
                    501
                );
            }
            $componente = new CurricularComponentCategory();
            $this->authorize('create', JWTAuth::user());
            $componente->fill($this->request->all());
            if (!$componente->save()) {
                throw new Exception('Não foi possível salvar categoria do componente', 422);
            }
        } catch (Exception $ex) {
            return $this->errorResponse(
                $data,
                $ex->getMessage(),
                $ex->getCode() > 0 &&  $ex->getCode() < 505 ? $ex->getCode() : 500
            );
        }
        return $this->successResponse($componente, 'Categoria do Componente curricular registrada com sucesso!!', 200);
    }

    /**
     * Lista os componentes e ordena o nome de forma crescente
     * @return string json
     */
    public function index()
    {
        $limit = $this->request->get('limit', 15);

        if ($this->request->has('select')) {
            return $this->showAll(
                CurricularComponentCategory::with('componentes')->orderBy('name', 'asc')->get()
            );
        }
        $componentesCategoria = CurricularComponentCategory::with('componentes')
            ->orderBy('name', 'asc')
            ->paginate($limit);

        return $this->showAsPaginator($componentesCategoria);
    }

    /**
     * Busca por termo
     * @return string json de objetos de categorias de componentes curriculares
     *
     */
    public function search($termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 20;
        $search = "%{$termo}%";
        //$paginator = CurricularComponentCategory::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])->paginate($limit);
        $query = CurricularComponentCategory::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search]);
        $paginator = CachingModelObjects::search($query, $termo, $limit);
        $paginator->setPath("/componentescategorias/search/{$termo}?limit={$limit}");
        return $this->showAsPaginator($paginator, '', 200);
    }
    /**
     * Busca por Id
     */
    public function getById($id)
    {
        $componentesCategoria = CurricularComponentCategory::with('componentes')
            ->findOrFail($id);
        
        
        return $componentesCategoria;
    }

    /**
     * Auto-Completação
     * @param string $term identificador único
     * @return string json
     */
    public function autocomplete($term)
    {
        $search = "%{$term}%";
        $limit = $this->request->query('limit', 100);
        $categories = CurricularComponentCategory::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->get(['id', 'name']);
        return $this->showAll(collect($categories));
    }

    /**
     * Deleta o aplicativo no banco de dados
     * @param int $id identificador único
     * @return string json
     * retorna Json
     */
    public function delete($id)
    {
        /*$validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                return $this->errorResponse($validator->errors(), "Não foi possível deletar.", 201);
            }
            */
            $category = CurricularComponentCategory::findOrFail($id);
            $this->authorize('delete', $category);
            if (!$category->delete()) {
                throw new Exception("Erro ao deletar a categoria: " . $category->name . " Tente novamente em seguida.");
            }
        /*}catch (Exception $ex) {
            return $this->errorResponse(
                [],
                $ex->getMessage(),
                $ex->getCode() > 0 &&  $ex->getCode() < 505 ? $ex->getCode() : 500
            ); 
        } */
        return $this->successResponse($category, 'Categoria do componente deletada com sucesso!', 200);
    }
    /**
     * Regras de Validação
     * @return string array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255'
        ];
    }
}
