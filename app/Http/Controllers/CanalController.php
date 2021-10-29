<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CanalRequest;

class CanalController extends ApiController
{
    /**
     * Metodo Construtor
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['getBySlug']);
        $this->request = $request;
    }
    /**
     * Display a indexing of the resource.
     * Exibe uma indexação do recurso.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 15;
        if ($this->request->has('select')) {
            $select = Canal::whereRaw('is_active = true AND id <> 9 AND id <> 7 AND id <> 8')
                ->orderBy('id')
                ->get(['id', 'name']);
            return $this->fetchForSelect(collect($select));
        }
        $canais = Canal::paginate($limit);
        $canais->setPath("/canais?limit={$limit}");
        return $this->showAsPaginator($canais);
    }
    /**
     * Show the form for creating a new resource.
     * Mostra o formulário de criação de um novo recurso.
     * @return json
     */
    public function create(CanalRequest $request)
    {
        $canal = new Canal;
        $this->authorize('create', $canal);


        $canal->fill($request->validated());


        if (!$canal->save()) {
            return $this->errorResponse([], 'Impossível cadastrar o canal', 422);
        }

        return $this->successResponse($canal, 'Canal cadastrado com sucesso!!', 200);
    }

    /**
     * 
     * Atualiza aplicativo no banco de dados
     * @param  int  $id identificador único
     * @param \App\Models\Canal $canal
     * @return \App\Traits\ApiResponser retorna json
     */
    public function update(CanalRequest $request, $id)
    {
        $canal = Canal::findOrFail($id);

        $this->authorize('update', $canal);

        $canal->fill($request->validated());

        if (!$canal->save()) {
            return $this->errorResponse([], 'Não foi possível editar o canal', 422);
        }

        return $this->successResponse($canal, 'Canal Editado com sucesso!', 200);
    }
    /**
     * Apaga um canal pelo ID.
     *
     * @param  \App\Canal  $canal
     * @return \App\Canal\Responser Retorna Json
     */
    public function delete($id)
    {
        $canal = Canal::findOrFail($id);

        $this->authorize('delete', [$canal]);

        if (!$canal->delete()) {
            $this->errorResponse([], "Não foi possível deletar o canal", 422);
        }

        return $this->successResponse([], "Canal apagado com sucesso!", 200);
    }
    /**
     * Seleciona Canal pela url amigável (SLUG)
     *
     * @param [type] $slug
     * @return void
     */
    public function getBySlug($slug)
    {
        $canal = Canal::with(['categories', 'appsCategories'])
            ->where('slug', $slug)->get()->first();

        if (!$canal) {
            return $this->errorResponse([], 'Não encontrado', 404);
        }

        return $this->showOne($canal, '', 200);
    }
    /**
     * Seleciona canal por ID
     */
    public function getById($id)
    {
        $cb = function ($query) {
            $query->whereNull('parent_id');
            $query->with('subCategories');
        };
        $canal = Canal::with(['categories' => $cb])->findOrFail($id);

        return $this->showOne($canal, '', 200);
    }
    /**
     * Procura canal pelo termo
     * Faz a Busca do termo
     * @param [type] $termo
     * @return void
     */
    public function search($termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 10;

        $search = "%{$termo}%";
        $canais = Canal::whereRaw("unaccent(lower(name)) LIKE unaccent(lower(?))")
            ->setBindings([$search])
            ->paginate($limit);

        $canais->setPath("/canais/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($canais);
    }
}
