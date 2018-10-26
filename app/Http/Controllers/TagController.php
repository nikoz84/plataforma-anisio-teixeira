<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
      $this->middleware('jwt.verify')->except(['list','search']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $limit = ($request->has('limit')) ? $request->query('limit'): 15;
        $page = ($request->has('page')) ? $request->query('page'): 1;

        $tags = DB::table('tags')
                    ->select(['id','name','searched'])
                    ->paginate($limit);

        $tags->setPath("/tags?limit={$limit}"); 
        
        return response()->json([
                'title'=> 'Lista de tags',
                'paginator' => $tags,
                'page'=> $tags->currentPage(),
                'limit' => $tags->perPage()
            ]);
    }

    /**
     * Show the form for creating a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $name = $request->get('name');
        
        $id = DB::table('tags')->insertGetId([ 
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
    public function update(Request $request, $id)
    {
        $name = ($request->has('name')) ? $request->get('name'): false;
        $is_update = false;
        if($name){
            $is_update = DB::table('tags')
                ->where('id', $id)
                ->update(['name' => $name]);
        }

        return response()->json([
            'message' => "Nome de tag: {$name} mudado com sucesso",
            'is_update' => $is_update
        ]);

    }

    public function incrementSearchTag(Request $request, $id)
    {
        
        if($request->has('searched')){
            
            $is_updated = DB::table('tags')
                                ->where('id', $id)
                                ->increment('searched', 1);
        }

        response()->json([
            'is_updated' => $is_updated,
            'id' => $id
        ]);
        
    }

    public function search(Request $request, $termo)
    {
        $limit = $request->query('limit', 15);
        $page = $request->query('page', 1);

        $tags = DB::table('tags')
                    ->select(['id','name'])
                    ->where(DB::raw('unaccent(lower(name))'), 'ILIKE' , DB::raw("unaccent(lower('%{$termo}%'))"))
                    ->paginate($limit);
        
        $tags->setPath("/tags/search/{$termo}?limit={$limit}");                                

        return response()->json([
            'message' => 'Resultados da busca',
            'paginator' => $tags,
            'page'=> $tags->currentPage(),
            'limit' => $tags->perPage()
        ]);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if($id){
            DB::table('tags')->where('id', '=', $id)->delete();
        }

        
    }
}
