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

Route::get('/canais', 'CanalController@index');

Route::post('/canais', 'CanalController@create');


Route::get('/conteudos', 'ConteudoController@index');


Route::get('/tags','TagController@list');
Route::post('/tags/create','TagController@create');
Route::put('/tags/update/{id}','TagController@update');
Route::delete('/tags/delete/{id}','TagController@delete');