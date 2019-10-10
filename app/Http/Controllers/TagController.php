<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TagController extends ApiController
{
    public function __construct(Request $request, Tag $tag)
    {
        $this->middleware('jwt.verify')->except(['index', 'search', 'getById']);
        $this->request = $request;
        $this->tag = $tag;
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

        $tag = $this->tag::firstOrCreate(['name' => $this->request->name]);

        if ($tag) {
            return $this->successResponse($tag, "Palavra chave - {$tag->name} - adicionada com sucesso!!", 200);
        } else {
            return $this->errorResponse([], "Não foi possivel adicionar a palavra chave", 201);
        }
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
        $tag = $this->tag::find($id);
        $tag->name = $this->request->name;

        if ($tag->save()) {
            return $this->showOne($tag, 'Palavra chave atualizada com sucesso!!', 200);
        } else {
            return $this->errorResponse([], 'Não foi possível editar', 200);
        }
    }

    public function search($termo)
    {
        $limit = $this->request->query('limit', 15);
        $search = "%{$termo}%";

        $tags = $this->tag::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->paginate($limit);
        $tags->setPath("/tags/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($tags, '', 200);
    }
    public function autocomplete($term)
    {
        $search = "%{$term}%";
        $limit = $this->request->query('limit', 100);
        $tags = $this->tag::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->get(['id', 'name']);
        return $this->fetchForSelect(collect($tags));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if ($id) {
            DB::table('tags')->where('id', '=', $id)->delete();
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function getById($id)
    {
        $tag = $this->tag::find($id);

        return $this->showOne($tag, '', 200);
    }
}
