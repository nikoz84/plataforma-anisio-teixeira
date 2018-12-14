<?php

namespace App\Http\Controllers;

use App\Options;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        //
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
    public function getByName(Request $request, Options $options, $name)
    {
        $option = $options->where('nome', 'like', $name)->first();

        return response()->json([
            'success'=> true,
            'options'=> $option
        ]);
    }
}
