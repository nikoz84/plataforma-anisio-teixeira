<?php

namespace App\Http\Controllers;

use App\Models\CurricularComponent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ComponentesController extends ApiController
{
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

        if ($this->request->has('select')) {
            return $this->showAll(
                CurricularComponent::orderBy('name', 'desc')->get()
            );
        }

        $componentes = CurricularComponent::orderBy('name', 'asc')
            ->paginate($limit);

        return $this->showAsPaginator($componentes);
    }

    /**
     * Atualiza aplicativo
     *
     * @param $id
     * @return CurricularComponent
     */
    public function update($id)
    {
        try {
            $component = CurricularComponent::find($id);
            $validator = Validator::make($this->request->all(), $this->rules());
            if ($validator->fails()) {
                throw new Exception('Não foi possível atualizar componente. Erro no preenchimento do formulário.', 404);
            }
            $component->fill($this->request->all());
            if (! $component->save()) {
                throw new Exception('Não foi possível atualizar componente. Tente novamente mais tarde', 501);
            }
        } catch (Exception $ex) {
            return $this->errorResponse([], $ex->getMessage(), $ex->getCode() > 0 ? $ex->getCode() : 500);
        }

        return $this->showOne($component, 'Componente Curricular atualizada com sucesso!!', 200);
    }

    /**
     * Método que pega o Componente curricular por ID
     *
     * @param  int  $id  ID identificador único
     * @return CurricularComponent
     */
    public function getById($id)
    {
        $component = new CurricularComponent;
        try {
            $component = CurricularComponent::with(['nivel', 'category'])->findOrFail($id);
        } catch (Exception $ex) {
            return $this->errorResponse([], 'Componente não encontrado', 422);
        }

        return $component;
    }

    /**
     * cria e salva um componente curricular atraves de dados via POST
     *
     * @return string json
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->rules());
        $data = [];
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception(
                    'Não foi possível criar componente. Erro no preenchimento do formulário de cadastro.',
                    501
                );
            }
            $componente = new CurricularComponent;
            $this->authorize('create', JWTAuth::user());
            $componente->fill($this->request->all());

            if (! $componente->save()) {
                throw new Exception('Não foi possível salvar componente', 422);
            }
        } catch (Exception $ex) {
            return $this->errorResponse(
                $data,
                $ex->getMessage(),
                $ex->getCode() > 0 && $ex->getCode() < 505 ? $ex->getCode() : 500
            );
        }

        return $this->successResponse($componente, 'Componente curricular registrada com sucesso!!', 200);
    }

    /**
     * Procura conteudos por full text search.
     *
     * @param $request \Illuminate\Http\Request
     * @param $termo   string termo de busca
     * @return App\Traits\ApiResponser
     */
    public function search(Request $request, $termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 20;
        $search = "%{$termo}%";
        $paginator = CurricularComponent::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])
            ->paginate($limit);

        $paginator->setPath("/licenses/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($paginator);
    }

    /**
     * Auto-Completação
     *
     * @param  string  $term identificador único
     * @return string json
     */
    public function autocomplete($term)
    {
        $search = "%{$term}%";
        $limit = $this->request->query('limit', 100);
        $tags = CurricularComponent::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->get(['id', 'name']);

        return $this->showAll(collect($tags));
    }

    /**
     * Deleta o aplicativo no banco de dados
     *
     * @param  int  $id ID identificador único
     * @return App\Traits\ApiResponser::successResponse Estrutura Padrão de retorno
     */
    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean],
        ]);
        try {
            if ($validator->fails()) {
                $data = $validator->errors();

                return $this->errorResponse($validator->errors(), 'Não foi possível deletar.', 201);
            }
            $component = CurricularComponent::findOrFail($id);
            $this->authorize('delete', $component);
            if (! $component->delete()) {
                throw new Exception('Erro ao deletar a categoria: '.$component->name.' Tente novamente em seguida.');
            }
        } catch (Exception $ex) {
            return $this->errorResponse(
                [],
                $ex->getMessage(),
                $ex->getCode() > 0 && $ex->getCode() < 505 ? $ex->getCode() : 500
            );
        }

        return $this->successResponse($component, 'Categoria do componente deletada com sucesso!', 200);
    }

    /**
     * Regras de validação
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
        ];
    }
}
