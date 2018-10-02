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
    public function list()
    {
        $tags = DB::table('tags')
                    ->select(['id','name','searched'])
                    ->limit(2)
                    ->offset(1)
                    ->get();
        
        return response()->json(
            [
                'title'=> 'Lista de tags',
                'tags' => $tags
            ]
        );
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
                'menssage' => "Tag: {$name} adicionada com sucesso",
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
        $name = $request->get('name');

        DB::table('tags')
            ->where('id', $id)
            ->update(['name' => $name]);
    }

    public function incrementSearchTag(Rquest $request, $id){
        
        DB::table('tags')->increment('searched', 1);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }
}
