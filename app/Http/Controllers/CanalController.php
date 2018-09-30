<?php

namespace App\Http\Controllers;

use App\Canal;
use Illuminate\Http\Request;

class CanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 10;
        $id = $request->has('id') ? $request->query('id') : 2;
        
        $canal = Canal::where('is_active', true)
            ->where('id',$id)
            ->orderBy('name', 'desc')
            ->take($limit)
            ->get();
        
        
        return $canal->toJson();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function show(Canal $canal)
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Canal $canal)
    {
        //
    }
}
