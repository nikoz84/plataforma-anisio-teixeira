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

// CANAIS
Route::get('/canais', 'CanalController@list');
Route::post('/canais/create', 'CanalController@create');
Route::put('/canais/update/{id}', 'CanalController@update');
Route::delete('/canais/delete/{id}', 'CanalController@delete');
// CONTEUDOS
Route::get('/conteudos', 'ConteudoController@list');
Route::get('/conteudos/search/{termo}', 'ConteudoController@search');
Route::post('/conteudos/create', 'ConteudoController@create');
Route::put('/conteudos/update/{id}', 'ConteudoController@update');
Route::delete('/conteudos/delete/{id}', 'ConteudoController@delete');
// TAGS
Route::get('/tags','TagController@list');
Route::get('/tags/search/{termo}','TagController@search');
Route::post('/tags/create','TagController@create');
Route::put('/tags/update/{id}','TagController@update');
Route::delete('/tags/delete/{id}','TagController@delete');    
