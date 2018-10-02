<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/canal', 'CanalController@index');


Route::post('/canais', function(){
    return json_encode(["error"=>"Falha ao carregar"]);
});

Route::post('/canais/inserir', 'CanalController@index');

