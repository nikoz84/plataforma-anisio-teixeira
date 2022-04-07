<?php

namespace App\Http\Controllers;

use App\Helpers\CachingModelObjects;
use App\Http\Controllers\ApiController;
use App\Models\Tipo;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class TipoController extends ApiController
{

    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except([
            'index',
            'search', 'getTiposById'
        ]);
        $this->request = $request;
    }
    /**
     * Lista as Informações do Aplicativo
     * 
     * @param int $id identificador único
     * @param \App\tipo $tipo
     * @return \App\Controller\ApiResponser 
     * retorna Json
     */
    public function index()
    {
        $limit = $this->request->query('limit', 15);
        if ($this->request->has('select')) {
            $tipos = Tipo::all();
            return '$this->fetchForSelect(collect($tipos))';
        }
        $query = Tipo::query();

        $paginator = $query->select()->paginate($limit);
        $paginator->setPath("/tipos?limit={$limit}");

        return $this->showAsPaginator($paginator);
    }

    /**
     * Cria as Informações do Aplicativo
     * 
     * @param string Request
     * @param \App\tipo $tipo
     * @return \App\Controller\ApiResponser 
     * retorna Json
     */

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['name' => 'required']
        );
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o tipo", 422);
        }
        $tipo = new Tipo;
        $this->authorize('create', User::class);
        $tipo->name = $request->name;
        $tipo->options = json_decode($request->options, true);
        if (!$tipo->save()) {
            return $this->errorResponse($tipo, 'Não foi possível editar o tipo de conteúdo', 422);
        }
        return $this->successResponse($tipo, 'Tipo criado com sucesso!', 200);
    }
    /**
     * Atualiza as informações do aplicativo
     * 
     * @param int $id identificador único
     * @param \App\tipo $tipo
     * @return \App\Controller\ApiResponser 
     * retorna Json
     */

    public function update(Request $request, $id)
    {
        $this->successResponse($request->all());
        $validator = Validator::make(
            $this->request->all(),
            [
                'name' => 'required'
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Preencha o formulário corretamente", 422);
        }
        $tipo = Tipo::findOrFail($id);
        $this->authorize('update', $tipo);
        $tipo->name = $this->request->name;
        $tipo->options = json_decode($this->request->options, true);
        if (!$tipo->save()) {
            return $this->errorResponse([], 'Não foi possível editar', 422);
        }

        return $this->successResponse($tipo, 'Tipo de conteúdo editado com sucesso!', 200);
    }
    /**
     * Deleta as Informações do Aplicativo
     * 
     * @param int $id identificador único
     * @param \App\tipo $tipo
     * @return \App\Controller\ApiResponser 
     * retorna Json
     */
    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean],
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível deletar.", 422);
        }

        $tipo = Tipo::findOrFail($id);

        $this->authorize('delete', $tipo);

        if (!$tipo->delete()) {
            return $this->successResponse([], 'Não foi possível deletar o tipo de conteúdo', 422);
        }

        return $this->successResponse($tipo, 'Tipo deletado com sucesso!', 200);
    }
    /**
     * Seleciona tipo por ID
     */
    public function getTiposById($id)
    {
        //$tipo = Tipo::find($id);
        $tipo = CachingModelObjects::getById(Tipo::query(), $id);
        return $this->showOne($tipo);
    }

    /**
     * Procura categoria pelo nome
     * @param $request \Illuminate\Http\Request
     * @param $termo string de busca
     * @return App\Traits\ApiResponser
     */
    public function search(Request $request, $termo)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 20;
        $search = "%{$termo}%";
        //$paginator = Tipo::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])->paginate($limit);
        $query =  Tipo::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search]);
        $paginator = CachingModelObjects::search($query, $termo, $limit);
        $paginator->setPath("/tipos/search/{$termo}?limit={$limit}");
        return $this->showAsPaginator($paginator, '', 200);
    }


    /**
     * pegar a quantidade de cada tipo de conteúdo
     */
    public function getQuantidadeTipos($id)
    {
        $sql = "SELECT (SELECT upper(name)
                FROM tipos AS t WHERE t.id = c.tipo_id) as name,
                COUNT (c.tipo_id) as total ,
                row_number() OVER () AS id
                FROM
                conteudos AS c
                /*WHERE c.tipo_id = $id*/
                GROUP BY name
                ORDER BY name ASC";

        return DB::select(DB::raw($sql));
    }
}
