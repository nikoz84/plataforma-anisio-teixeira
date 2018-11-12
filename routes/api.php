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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


// CANAIS
Route::get('/canais/slug/{slug}', 'CanalController@getBySlug');
// CONTEUDOS
Route::get('/conteudos', 'ConteudoController@list');
Route::get('/conteudos/search/{term}', 'ConteudoController@search');
Route::get('/conteudos/teste', 'ConteudoController@teste');
Route::get('/conteudos/{id}', 'ConteudoController@getById');
// APLICATIVOS
Route::get('/aplicativos', 'AplicativoController@list');
Route::get('/aplicativos/search/{term}','AplicativoController@search');
Route::get('/aplicativos/{id}', 'AplicativoController@getById');
// AUTH
Route::post('/auth/login', 'AuthController@login')->name('login');
Route::post('/auth/register', 'AuthController@register')->name('register');
// OPTIONS
Route::post('options/name/{name}','OptionsController@getByName');

Route::group(['middleware' => ['jwt.verify']], function() {
    
    // AUTH
    Route::post('/auth/logout', 'AuthController@logout')->name('logout');
    Route::post('/auth/refresh', 'AuthController@refresh')->name('refresh');
    Route::post('/auth/user', 'AuthController@getAuthUser')->name('me');

    // USUARIO
    Route::get('/users/search/{term}', 'UserController@search');
    Route::delete('/users/delete/{id}', 'UserController@delete');
    Route::delete('/users/{id}', 'UserController@getById');
    Route::get('/users', 'UserController@list');
    Route::put('/users/reset_pass', 'UserController@resetPass');
    // APLICATIVOS
    Route::post('/aplicativos/create', 'AplicativoController@create');
    Route::put('/aplicativos/update/{id}', 'AplicativoController@update');
    Route::delete('/aplicativos/delete/{id}', 'AplicativoController@delete');

    // TAGS
    Route::get('/tags','TagController@list');
    Route::get('/tags/search/{term}','TagController@search'); 
    Route::post('/tags/create','TagController@create');
    Route::put('/tags/update/{id}','TagController@update');
    Route::delete('/tags/delete/{id}','TagController@delete');

    // CONTEÚDOS 
    Route::post('/conteudos/create', 'ConteudoController@create');
    Route::put('/conteudos/update/{id}', 'ConteudoController@update');
    Route::delete('/conteudos/delete/{id}', 'ConteudoController@delete');

    // CANAIS
    Route::post('/canais/create', 'CanalController@create');
    Route::put('/canais/update/{id}', 'CanalController@update');
    Route::delete('/canais/delete/{id}', 'CanalController@delete');
    Route::get('/canais', 'CanalController@list');
    Route::get('/canais/search/{term}', 'CanalController@search');

    // Licencas
    Route::get('/licencas','LicencaController@list');
    Route::get('/licencas/search/{term}', 'LicencaController@search');
    Route::post('/licencas/create','LicencaController@create');
    Route::put('/licencas/update/{id}','LicencaController@update');
    Route::delete('/licencas/delete/{id}','LicencaController@delete');

    // Administração
    Route::get('/admin','TagController@list');
    
});