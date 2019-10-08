<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Traits\ApiResponser;

class TagController extends ApiController
{
    use ApiResponser;

    public function __construct(Request $request, Tag $tag)
    {
        $this->middleware('jwt.verify')->except(['list', 'search', 'getById']);
        $this->request = $request;
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
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
        $name = $this->request->get('name');

        $id = Tag::insertGetId([
            'name' => $name
        ]);

        return response()->json([
            'menssage' => "Tag - {$name} - adicionada com sucesso",
            'id' => $id
        ]);
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
        $name = ($this->request->has('name')) ? $this->request->get('name') : false;
        $is_update = false;
        if ($name) {
            $is_update = Tag::where('id', $id)
                ->update(['name' => $name]);
        }

        return response()->json([
            'message' => "Nome de tag: {$name} mudado com sucesso",
            'is_update' => $is_update
        ]);
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
        $tag = Tag::where('id', $id);
        return response()->json([
            'success' => true,
            'tag' => $tag
        ]);
    }
}
