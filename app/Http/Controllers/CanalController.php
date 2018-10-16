<?php

namespace App\Http\Controllers;

use App\Canal;
use App\Conteudo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        
        $limit = ($request->has('limit')) ? $request->query('limit') : 10;        
        $page = ($request->has('page')) ? $request->query('page') : 1;        
        $canais = Canal::where('is_active', true)
                        ->limit($limit)
                        ->offset($page)
                        ->paginate($limit);
        $canais->currentPage($page);

        return response()->json([
            'title'=> 'Lista de canais',
            'paginator' => $canais
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = DB::table('canais')->insertGetId(
            [
                'name' => 'Canal Teste',
                'description' => 'Adicionando um novo canal no banco de dados.',
                'slug' => 'teste-slug',
                'is_active' => true 
            ]
        );
        return response()->json([
            'message' => 'Canal cadastrado com sucesso',
            'id' => $id
        ]);
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $canal = Conteudo::find($id);
        
        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'is_featured' => $request->get('is_featured'), 
            'is_approved' => $request->get('is_approved'), 
            'options' => $request->get('options')
        ];
        
        $canal->save($data);
        
        return response()->json($canal->toJson());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $canal = Conteudo::find($id);
        $resp = [];
        if(is_null($canal)){
            $resp = [
                'menssage' => 'Canal não encontrado',
                'is_deleted' => false
            ];
        }else {
            $resp = [
                'menssage' => "Canal de id: {$id} foi excluido com sucesso!!",
                'is_deleted' => $canal->delete()
            ];
        }
        
        return response()->json($resp);
    }
}