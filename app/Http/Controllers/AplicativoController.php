<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $id = ($request->has('aplicativo')) ? $request->query('aplicativo') : 2;
        $orderBy = ($request->has('order')) ? $request->query('order') : 'title';
        $page = ($request->has('page')) ? $request->query('page') : 1;
        
        $conteudos = DB::table('aplicativo')
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
}
