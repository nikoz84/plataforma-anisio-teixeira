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
    public function index(Canal $canal, Request $request)
    {
        $limit = $request->query('limit');

        $canais = Canal::where('is_active', true)
            ->orderBy('name', 'desc')
            ->take($limit)
            ->get();
        
        return $canais->toJson();
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
