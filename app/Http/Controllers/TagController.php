<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends ApiController
{
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search', 'getById']);
        $this->request = $request;
    }

    /**
     * Display a indexing of the resource.
     * Exibe uma indexação do recurso
     *
     * @return string json
     */
    public function index()
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 15;

        $tags = Tag::select(['id', 'name', 'searched'])
            ->orderBy('name')
            ->paginate($limit);

        $tags->setPath("/tags?limit={$limit}");

        return $this->showAsPaginator($tags, '', 200);
    }

    /**
     * Show the form for creating a new resource.
     * Mostra o formulário para criar um novo recurso.
     *
     * @return string json
     */
    public function create()
    {
        $validator = Validator::make(
            $this->request->all(),
            [
                'name' => 'required|unique:tags',
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Não foi possível atualizar a palavra-chave', 422);
        }
        $tag = Tag::firstOrCreate([
            'name' => $this->request->name,
            'searched' => Tag::INIT_SEARCHED,
        ]);

        if (! $tag->save()) {
            return $this->errorResponse([], 'Não foi possivel adicionar a palavra-chave', 422);
        }

        return $this->successResponse($tag, "Palavra-chave: {$tag->name} - adicionada com sucesso!!", 200);
    }

    /**
     * Update the specified resource in storage.
     * Atualiza o recurso especificado no armazenamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return string json
     */
    public function update($id)
    {
        $tag = Tag::findOrFail($id);
        $validator = Validator::make($this->request->all(), ['name' => 'required']);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Não foi possível editar o palavra-chave', 422);
        }
        $tag->name = $this->request->name;

        if (! $tag->save()) {
            return $this->errorResponse([], 'Não foi possível editar', 422);
        }

        return $this->showOne($tag, 'Palavra-chave atualizada com sucesso!!', 200);
    }

    /**
     *  Método que Busca as informações do Banco de Dados
     *
     * @param  string  $termo identificador único
     * @param  \App\Tag  $tag
     * @return \App\Controller\ApiResponser
     * @return string Json
     */
    public function search($termo)
    {
        $limit = $this->request->query('limit', 15);
        $search = "%{$termo}%";

        $tags = Tag::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->orderBy('name')
            ->paginate($limit);

        $tags->setPath("/tags/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($tags);
    }

    /**
     * Auto Completar
     *
     * @param  string  $term identificador único
     * @param  \App\Tag  $tag
     * @return \App\Controller\ApiResponser
     * @return string Json
     */
    public function autocomplete($term)
    {
        $search = "%{$term}%";
        $limit = $this->request->query('limit', 200);
        $tags = Tag::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->where('name', 'NOT LIKE', '% %')
            ->distinct()
            ->get(['id', 'name'])->take($limit);

        return $this->showAll(collect($tags));
    }

    /**
     * Delete information from the Database.
     * Deleta informações no Banco de Dados
     *
     * @param  int  $id identificador único
     * @param  \App\tag  $tag
     * @return string json
     */
    public function delete($id)
    {
        $tag = Tag::findOrFail($id);

        if (! $tag->delete()) {
            $this->errorResponse([], 'Impossível deletar a palavra-chave', 422);
        }

        $this->successResponse([], 'Palavra-chave apagada com sucesso!', 200);
    }

    /**
     * Requisita as informações no Banco de Dados
     *
     * @param  int  $id identificador único
     * @param  \App\tag  $tag
     * @return string json
     */
    public function getById($id)
    {
        $tag = Tag::findOrFail($id);

        return $this->showOne($tag, '', 200);
    }
}
