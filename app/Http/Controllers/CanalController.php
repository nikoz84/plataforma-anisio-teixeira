<?php

namespace App\Http\Controllers;

use App\Canal;
use App\Helpers\SideBar;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Auth\Access\Gate;

class CanalController extends ApiController
{
    public function __construct(Request $request, Canal $canal)
    {
        $this->middleware('jwt.verify')->except(['getBySlug']);
        $this->request = $request;
        $this->canal = $canal;
    }
    /**
     * Display a indexing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 15;

        if ($this->request->has('select')) {
            $select = $this->canal::whereRaw('is_active = true AND id <> 9 AND id <> 7 AND id <> 8')
                ->orderBy('id')
                ->get(['id', 'name']);
            return $this->fetchForSelect(collect($select));
        }

        $canais = $this->canal::paginate($limit);
        $canais->setPath("/canais?limit={$limit}");

        return $this->showAsPaginator($canais);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return json
     */
    public function create()
    {
        $canal = $this->canal;

        $canal->name = $this->request->name;
        $canal->slug = $this->request->slug;
        $canal->description = $this->request->description;
        $canal->is_active = $this->request->is_active;
        $canal->options = json_decode($this->request->options, true);

        if (!$canal->save()) {
            return $this->errorResponse([], 'Impossível cadastrar o canal', 422);
        }

        return $this->successResponse($canal, 'Canal cadastrado com sucesso!!', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $canal = $this->canal::find($id);

        $canal->name = $this->request->name;
        $canal->slug = $this->request->slug;
        $canal->description = $this->request->description;
        $canal->is_active = $this->request->is_active;
        $canal->options = json_decode($this->request->options, true);

        if (!$canal->save()) {
            return $this->errorResponse([], 'Não foi possível editar o canal', 422);
        }

        return $this->successResponse($canal, 'Canal Editado com sucesso!', 200);
    }
    /**
     * Apaga um canal pelo ID.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $canal = $this->canal::findOrFail($id);

        if (Gate::denies('super-admin', $canal)) {
            return $this->errorResponse([], 'Usuário sem permissão para realizar essa ação', 422);
        }
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
        $canal = $this->canal::with(['categories', 'appsCategories'])
            ->where('slug', 'ilike', $slug)->first();

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
        $canal = $this->canal::with(['categories' => $cb])->findOrFail($id);

        return $this->showOne($canal, '', 200);
    }
    /**
     * Procura canal pelo termo
     *
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

        return response()->json([
            'success' => true,
            'paginator' => $canais,
        ]);
    }
}
