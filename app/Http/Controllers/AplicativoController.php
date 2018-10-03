<?php

namespace App\Http\Controllers;

use App\Aplicativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AplicativoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 10;
        $id = ($request->has('aplicativos')) ? $request->query('aplicativos') : 2;
        $orderBy = ($request->has('order')) ? $request->query('order') : 'title';
        $page = ($request->has('page')) ? $request->query('page') : 1;
        
        $conteudos = DB::table('aplicativos')
            ->select(['id','user_id','name','description'])
            ->where('is_featured', true)
            ->where('id', $id)
            ->orderBy($orderBy, 'name')
            ->paginate($limit);
                    
        $conteudos->currentPage($page);
        
        return response()->json([
            'title'=> 'Aplicativos Educacionais',
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
        $id = DB::table('aplicativos')->insertGetId(
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Editor de Texto',
                'description'=> 'Descricao do Aplicativo Educacional',
                'is_featured' => false,
                'options' => '{}'

            ]
        );
        return response()->json([
            'message' => 'Aplicativo cadastrado com sucesso',
            'id' => $id
        ]);
    }

/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aplicativo  $aplicativo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $aplicativo = Aplicativo::find($id);
        
        $data = [
            'name' => $request->get('title'),
            'description' => $request->get('description'),
            'is_featured' => $request->get('is_featured'), 
            'options' => $request->get('options')
        ];
        
        $aplicativo->save($data);
        
        return response()->json($aplicativo->toJson());
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aplicativo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $aplicativo = Aplicativo::find($id);
        $resp = [];
        if(is_null($aplicativo)){
            $resp = [
                'menssage' => 'Aplicativo não encontrado',
                'is_deleted' => false
            ];
        }else {
            $resp = [
                'menssage' => "Aplicativo de id: {$id} foi apagado com sucesso!!",
                'is_deleted' => $aplicativo->delete()
            ];
        }
        
        return response()->json($resp);
    }

    public function search(Request $request, $termo)
    {
        $aplicativo = DB::table('aplicativos')
                    ->select(['id','name'])
                    ->where(DB::raw('unaccent(lower(name))'), 'ILIKE' , DB::raw("unaccent(lower('%{$termo}%'))"))
                    ->get();
        
        return response()->json([
            'message' => 'Resultados da busca',
            'items' => $aplicativo
        ]);    
    }



}
