<?php

namespace App\Http\Controllers;

use App\Canal;
use App\Conteudo;
use Illuminate\Http\Request;

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
        //$id = ($request->has('canal')) ? $request->query('canal') : 2;
        //$orderBy = ($request->has('order')) ? $request->query('order') : 'description';
        $page = ($request->has('page')) ? $request->query('page') : 1;
        
        $canal = Canal::where('is_active', true)
            //->where('id',$id)
            //->orderBy($orderBy, 'description')
            ->limit($limit)
            ->offset($page)
            ->get();

        return $canal->toJson(JSON_PRETTY_PRINT);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
