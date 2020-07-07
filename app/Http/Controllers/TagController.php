<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
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
     *
     * @return \Illuminate\Http\Response
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
     * Show the form for creating a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), 
            [
                'name' => 'required'
            ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar o conteúdo", 422);
        }
        $tag = TAG::firstOrCreate([
            'name' => $this->request->name,
            'searched' => TAG::INIT_SEARCHED
        ]);

        if (!$tag->save()) {
            return $this->errorResponse([], "Não foi possivel adicionar a palavra chave", 422);
        }

        return $this->successResponse($tag, "Palavra chave - {$tag->name} - adicionada com sucesso!!", 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $tag = TAG::findOrFail($id);
        $validator = Validator::make($this->request->all(), ["name" => "required"]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível editar o tag", 422);
        }
        $tag->name = $this->request->name;

        if (!$tag->save()) {
            return $this->errorResponse([], 'Não foi possível editar', 422);
        }

        return $this->showOne($tag, 'Palavra chave atualizada com sucesso!!', 200);
    }

    public function search($termo)
    {
        $limit = $this->request->query('limit', 15);
        $search = "%{$termo}%";

        $tags = TAG::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->orderBy('name')
            ->paginate($limit);

        $tags->setPath("/tags/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($tags);
    }
    public function autocomplete($term)
    {
        $search = "%{$term}%";
        $limit = $this->request->query('limit', 100);
        $tags = TAG::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->get(['id', 'name']);
        return $this->showAll(collect($tags));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $tag = TAG::findOrFail($id);

        if (!$tag->delete()) {
            $this->errorResponse([], "Impossível deletar tag", 422);
        }

        $this->successResponse([], "Tag apagada com sucesso!", 200);
    }

    public function getById($id)
    {
        $tag = TAG::findOrFail($id);

        return $this->showOne($tag, '', 200);
    }
}
