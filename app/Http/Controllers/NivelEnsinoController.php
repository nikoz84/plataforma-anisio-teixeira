<?php

namespace App\Http\Controllers;

use App\CurricularComponent;
use App\License;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\NivelEnsino;
use App\Traits\FileSystemLogic;
use Exception;
use Illuminate\Support\Facades\Validator;
use Gate;
use Tymon\JWTAuth\Facades\JWTAuth;

class NivelEnsinoController extends ApiController
{
    use FileSystemLogic;

    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search']);
        $this->request = $request;
    }

    /**
     * Lista das Niveos de Ensino.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = $this->request->get('limit', 15);
        $niveisensino = NivelEnsino::select("*")
            ->limit($limit)
            ->orderBy('name', 'asc')
            ->paginate($limit);
        return $this->showAsPaginator($niveisensino);
    }

    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->rules());
        $data = [];
        
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception(
                    "Não foi possível criar Nível de Ensino. Erro no preenchimento do formulário de cadastro.",
                    501
                );
            }
            $nivel = new NivelEnsino();
            $this->authorize('create', JWTAuth::user());
            $nivel->fill($this->request->all());
           
            if (!$nivel->save()) {
                throw new Exception('Não foi possível salvar Nível de Ensino', 422);
            }
        } catch (Exception $ex) {
            return $this->errorResponse(
                $data,
                $ex->getMessage(),
                $ex->getCode() > 0 &&  $ex->getCode() <505 ? $ex->getCode() : 500
            );
        }
        return $this->successResponse($nivel, 'Nível de ensino foi registrada com sucesso!!', 200);
    }

    /**
     * obtem json do nivel de ensino a partir do seu id
     * @param int $id
     * @return string nivel de sensino em formtato json
     */
    public function getById($id)
    {
        $nivel = new NivelEnsino();
        try {
            $nivel = NivelEnsino::findOrFail($id);
            $nivel->componentes;
        } catch (Exception $ex) {
            return $this->errorResponse(
                [],
                $ex->getMessage(),
                $ex->getCode() > 0 &&  $ex->getCode() <505 ? $ex->getCode() : 500
            );
        }
        return $nivel;
    }

    /**
     * @param string termo para filtrar por nome
     * @return string json dos objetos de nivel de ensino filtrados
     */
    public function search($termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 20;
        $search = "%{$termo}%";
        $paginator = NivelEnsino::whereRaw(
            'unaccent(lower(name)) ILIKE unaccent(lower(?))',
            [$search]
        )->paginate($limit);
        $paginator->setPath("/componentescategorias/search/{$termo}?limit={$limit}");
        return $this->showAsPaginator($paginator, '', 200);
    }

    /**
     * Deleta o aplicativo no banco de dados
     * @param int $id identificador único
     * @return \App\Controller\ApiResponser
     */
    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                return $this->errorResponse($validator->errors(), "Não foi possível remover.", 201);
            }
            $nivel = NivelEnsino::findOrFail($id);
            $this->authorize('delete', $nivel);
            if (!$nivel->delete()) {
                throw new Exception("Erro ao deletar o nível de ensino: ".$nivel->name." Tente novamente em seguida.");
            }
        } catch (Exception $ex) {
            return $this->errorResponse(
                [],
                $ex->getMessage(),
                $ex->getCode() > 0 &&  $ex->getCode() <505 ? $ex->getCode() : 500
            );
        }
        return $this->successResponse($nivel, 'Nível de Ensino foi removido com sucesso!', 200);
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
        $niveis = NivelEnsino::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->get(['id', 'name']);
        return $this->showAll(collect($niveis));
    }

    /**
     * obtem array com o par chave|valor com regras de preenchimento dos dados de niveis de ensino
     * @return array regras do nivel de ensino ao popular base de dados
     */
    public function rules()
    {
        return [
            'name'=> 'required|min:2|max:255'
        ];
    }
}
