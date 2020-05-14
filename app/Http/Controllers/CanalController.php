<?php

namespace App\Http\Controllers;

use App\Canal;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class CanalController extends ApiController
{
    public function __construct(Request $request, Canal $canal)
    {
        $this->middleware('jwt.auth')->except(['getBySlug']);
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
    public function create(Request $request)
    {
        $this->authorize('create', Canal::class);
        
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'description' => 'required',
                'slug' => 'required',
                'is_active' => 'required'
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                "Não foi possível criar o conteúdo",
                422
            );
        }

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
        $canal = $this->canal::findOrFail($id);

        $this->authorize('update', [$canal]);

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

        return $this->showAsPaginator($canais);
    }
}
