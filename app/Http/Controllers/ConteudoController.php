<?php

namespace App\Http\Controllers;

use App\Conteudo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ConteudoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 5;

        $orderBy = ($request->has('order')) ? $request->query('order') : 'title';
        $page = ($request->has('page')) ? $request->query('page') : 1;

        $conteudos = DB::table('conteudos')
            ->select(['id','canal_id','user_id','title'])
            ->where('is_approved', true)
            ->where('canal_id', $request->query('id'))
            ->orderBy($orderBy, 'desc')
            ->paginate($limit);

        $conteudos->currentPage($page);

        return response()->json([
            'title'=> 'Mídias educacionais',
            'paginator'=> $conteudos
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = Conteudo::createinsertGetId(
            [
                'user_id' => $request->get('user_id'),
                'canal_id' => $request->get('canal_id'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'authors' => $request->get('authors'),
                'source' => $request->get('source'),
                'is_featured' => $request->get('is_featured'), 
                'is_approved' => $request->get('is_approved'),
                'is_site' =>  $request->get('is_site'),
                'options' => $request->get('options') 
            ]
        );
        return response()->json([
            'message' => 'Conteúdo cadastrado com sucesso',
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $idConteudo = DB::table('conteudos')
                        ->where('id', $id)
                        ->update( [
                            'title' => $request->get('title'),
                            'description' => $request->get('description'),
                            'authors' => $request->get('authors'),
                            'source' => $request->get('source'),
                            'is_featured' => $request->get('is_featured'), 
                            'is_approved' => $request->get('is_approved'),
                            'is_site' =>  $request->get('is_site'),
                            'options' => $request->get('options')
                        ]);
        
        $conteudo->save($data);

        
        return response()->json($conteudo->toJson());

        
    }
    public function createConteudoTags(Request $request, $id)
    {
        $conteudo = Conteudo::find($id);
        $conteudo->tags()->attach($request->get('tags'));

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $conteudo = Conteudo::find($id);
        $resp = [];
        if(is_null($conteudo)){
            $resp = [
                'menssage' => 'Conteúdo não encontrado',
                'is_deleted' => false
            ];
        }else {
            $resp = [
                'menssage' => "Conteúdo de id: {$id} foi apagado com sucesso!!",
                'is_deleted' => $conteudo->delete()
            ];
        }
        
        return response()->json($resp);
    }

    public function search(Request $request, $termo)
    {
        $conteudos = DB::table(DB::raw("conteudos as cd, plainto_tsquery('simple', lower(unaccent('${termo}'))) query"))
                    ->select(['cd.id','cd.title',
                            DB::raw('ts_rank_cd(cd.ts_documento, query) AS ranking')
                            ])
                    ->whereRaw('query @@ cd.ts_documento')
                    //->where('cd.is_approved', '=', 'true' )
                    ->orderBy('ranking','desc')
                    ->get();
        
        return response()->json([
            'message' => 'Resultados da busca',
            'items' => $conteudos
        ]);    
    }

    public function teste(){
        $conteudo = Conteudo::find(4);
        //$conteudo->tags()->detach([1,5]);
        
        
        return response()->json([
            'tags' => $conteudo->tags
        ]);
    }
}

