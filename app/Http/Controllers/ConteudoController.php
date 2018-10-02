<?php

namespace App\Http\Controllers;

use App\Conteudo;

use Illuminate\Http\Request;

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
        
        $conteudos = Conteudo::where('is_approved', true)
            ->where('canal_id',$id)
            ->orderBy($orderBy, 'desc')
            ->limit($limit)
            ->offset($page)
            ->get();

        return $conteudos->toJson(JSON_PRETTY_PRINT);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return '';
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
}
