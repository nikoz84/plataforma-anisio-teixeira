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
    public function index()
    {
        $canal = Canal::orderBy('created_at', 'name')->paginate(2);
        return view('canais.index',['canais'=> $canal]);
    }

    //public function index(Canal $canal, Request $request)
    //{
        //$limit = ($request->has('limit')) ? $request->query('limit') : 10;
        //$id = $request->has('id') ? $request->query('id') : 2 ;
        
       // $canal = Canal::where('is_active', true)
            //->where('slug','tv-anisio-teixeira')
            //->orderBy('name', 'desc')
            //->take($limit)
            //->get();
       
        
       // return $canal->toJson();
    //}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('canal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CanalRequest $request)
    {
        $canal = new Canal;
        $canal->name = $request->name;
        $canal->description = $request->description;
        $canal->slug = $request->slug;
        $canal->is_active = $request->is_active;
        $canal->options = $request->options;
        $canal->created_at = $request->created_at;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function show(Canal $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function edit(Canal $canal)
    {
        $canal = Canal::findOrFail($id);
        return view('canal.edit',compact('canal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Canal $canal)
    {
        $canal = Canal::findOrFail($id);
        $canal->name        = $request->name;
        $canal->description = $request->description;
        $canal->slug        = $request->slug;
        $canal->is_active   = $request->is_active;
        $canal->options     = $request->options;
        $canal->created_at  = $request->created_at;
        $canal->save();
        return redirect()->route('canal.index')->with('message', 'Canal atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Canal $canal)
    {
        $canal = Canal::findOrFail($id);
        $canal->delete();
        return redirect()->route('canal.index')->with('alert-success','Conteúdo deste canal foi deletado!');
    }
}
