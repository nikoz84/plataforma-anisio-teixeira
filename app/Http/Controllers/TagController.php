<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $limit = ($request->has('limit')) ? $request->query('limit'): 5;
        if( $limit > 60 || $limit < 0 ){
            $limit = 5;
        }

        $tags = DB::table('tags')
                    ->select(['id', 'name', 'searched'])
                    ->orderBy('name', 'desc')
                    ->offset(1)
                    ->limit($limit)
                    ->get();
        
        return response()->json([
            'titulo'=> 'Lista de Tags',
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [
            'all' => $request->all()
        ];
        return response()->json([
            'hola' => true,
            'data' => $data
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
        return response()->json([
            'hola' => true,
            'id' => $id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        return response()->json([
            'hola' => true,
            'id' => $id
        ]);

    }
}
