<?php

namespace App\Http\Controllers;

use App\Options;
use Illuminate\Http\Request;
use JWTAuth;

class OptionsController extends Controller
{
    public function __construct(Options $options)
    {
        $this->options = $options;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list() {
        $user = JWTAuth::parseToken()->toUser();
        $options = $this->options::all();
        return response()->json([
            'success' => true,
            'options' => $options,
            'user' => $user,
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
    public function update($name)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function delete($name)
    {
        //
    }
    public function getByName($name)
    {
        $option = $this->options::where('name', 'like', $name)->first();

        return response()->json([
            'success' => true,
            'options' => $option,
        ]);
    }
}
