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
Route::get('/canais', 'CanalController@index');
<<<<<<< HEAD
Route::post('/canais/create', 'CanalController@create');
Route::put('/canais/update/{id}', 'CanalController@update');
Route::delete('/conais/delete/{id}', 'CanalController@destroy');
// CONTEUDOS
Route::get('/conteudos', 'ConteudoController@index');
Route::post('/conteudos/create', 'ConteudoController@create');
Route::put('/conteudos/update/{id}', 'ConteudoController@update');
Route::delete('/conteudos/delete/{id}', 'ConteudoController@destroy');
// TAGS
Route::resource('/tags','TagController');
Route::post('/tags/create','TagController@create');
Route::put('/tags/update/{id}','TagController@update');
Route::delete('/tags/delete/{id}','TagController@destroy');    
=======

Route::post('/canais', 'CanalController@create');


Route::get('/conteudos', 'ConteudoController@index');


Route::get('/tags','TagController@list');
Route::post('/tags/create','TagController@create');
Route::put('/tags/update/{id}','TagController@update');
Route::delete('/tags/delete/{id}','TagController@delete');
>>>>>>> 603cb51962688a24708b9d6130894d8e2b5e876e
