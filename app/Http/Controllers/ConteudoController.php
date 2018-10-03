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
        $limit = ($request->has('limit')) ? $request->query('limit') : 10;
        $id = ($request->has('canal')) ? $request->query('canal') : 2;
        $orderBy = ($request->has('order')) ? $request->query('order') : 'title';
        $page = ($request->has('page')) ? $request->query('page') : 1;
        
        $conteudos = DB::table('conteudos')
            ->select(['id','canal_id','user_id','title'])
            ->where('is_approved', true)
            ->where('canal_id', $id)
            ->orderBy($orderBy, 'desc')
            ->paginate($limit);
                    
        $conteudos->currentPage($page);
        
        return response()->json([
            'title'=> 'Mídias Educacionais',
            'paginator'=> $conteudos
        ]);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = DB::table('conteudos')->insertGetId(
            [
                'canal_id' => 1,
                'user_id' => 1,
                'title' => 'conteudo 1',
                'description'=> 'Descricao do conteudo digital',
                'is_approved' => true, 
                'is_featured' => false, 
                'autores' => 'niko;fabiano;julio',
                'fonte' => 'anisio teixeira',
                'qt_downloads' => 1,
                'qt_acessos' => 2,
                'options' => '{}'  
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
        $conteudo = Conteudo::find($id);
        
        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'is_featured' => $request->get('is_featured'), 
            'is_approved' => $request->get('is_approved'), 
            'options' => $request->get('options')
        ];
        
        $conteudo->save($data);
        
        return response()->json($conteudo->toJson());

        
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
        $conteudos = DB::table(DB::raw("conteudos, plainto_tsquery(lower(unaccent('${termo}'))) AS query"))
                    ->select(['id','title',
                            DB::raw('ts_rank_cd(cd.ts_documento, query) AS ranking')
                            ])
                    ->whereRaw('query @@ ts_documento')
                    ->where('cd.flaprovado', '=', true )
                    ->orderBy('ranking','desc')
                    ->get();
        
        return response()->json([
            'message' => 'Resultados da busca',
            'items' => $conteudos
        ]);    
    }
}

