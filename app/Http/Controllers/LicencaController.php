<?php

namespace App\Http\Controllers;

use App\Licenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LicencaController extends Controller
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
        $limit = ($request->has('limit')) ? $request->query('limit') : 10;
        $page = ($request->has('page')) ? $request->query('page') : 1;

        $paginator = Licenca::paginate($limit);

        $paginator->setPath("/licencas?limit={$limit}"); 
        
        return response()->json([
                'title'=> 'Lista de Licenças',
                'paginator' => $paginator
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Options $options)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function delete(Options $options)
    {
        //
    }
    public function search(Request $request, $termo)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 20; 

        $paginator = Licenca::where(DB::raw('unaccent(lower(name))'), 'ILIKE' , DB::raw("unaccent(lower('%{$termo}%'))"))
                    ->paginate($limit);
        
        $paginator->setPath("/licencas/search/{$termo}?limit={$limit}"); 
        
        return response()->json([
            'title'=> 'Resultado da busca',   
            'paginator' => $paginator
        ]);              
      
    }
}
