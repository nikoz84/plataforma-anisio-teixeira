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

Route::group(['middleware' => ['cors']], function () {

    Route::get('/files/gallery', 'FileController@getGallery')->name('lista.galeria.imagens');
    Route::get('/files/{id}', 'FileController@getFiles')->name('busca.arquivo');
    Route::post('/files/{id}', 'FileController@createFile')->name('adiciona.arquivo');
    Route::get('/destaques', 'HomeController@getHomeData')->name('dados.home');
    Route::get('/layout', 'HomeController@getLayout')->name('lista.links');
    /** CATEGORIAS */
    Route::get('/categories', 'CategoryController@list')->name('lista.categorias');
    Route::get('/categories/aplicativos', 'CategoryController@getAplicativoCategories')
        ->name('lista.categorias.aplicativos');
    /** TIPOS */
    Route::get('/tipos', 'TipoController@list')->name('listar.tipos');

    /** DENUNCIA E FALE CONOSCO */
    Route::get('/denuncias', 'DenunciaController@list')->name('listar.denuncias');
    Route::post('/denuncias', 'DenunciaController@create')->name('criar.denuncias');
    Route::post('/faleconosco', 'FaleconoscoController@create')->name('criar.faleconosco');
    /** CANAIS */
    Route::get('/canais/slug/{slug}', 'CanalController@getBySlug')->name('buscar.canal.x.url.amigavel');
    /** CONTEUDOS */
    Route::get('/conteudos', 'ConteudoController@list')->name('lista.conteudo');
    Route::get('/conteudos/sites', 'ConteudoController@getSitesTematicos')->name('lista.sites.tematicos');
    Route::get('/conteudos/search/{term}', 'ConteudoController@search')->name('busca.conteudo');
    Route::get('/conteudos/teste', 'ConteudoController@teste');
    Route::get('/conteudos/{id}', 'ConteudoController@getById')->name('busca.x.conteudo.id');
    Route::get('/conteudos/tag/{id}', 'ConteudoController@getByTagId')->name('busca.x.tag.id');
    /** BLOG */
    Route::get('/posts', 'WordpressController@list')->name('lista.postagens');
    Route::get('/posts/estatisticas', 'WordpressController@getEstatisticas')->name('estatisticas.blog');
    /** APLICATIVOS */
    Route::get('/aplicativos', 'AplicativoController@list')->name('lista.aplicativo');
    Route::get('/aplicativos/search/{term}', 'AplicativoController@search')->name('busca.aplicativo');
    Route::get('/aplicativos/{id}', 'AplicativoController@getById')->name('busca.x.aplicativo.id');
    /** AUTENTICACAO */
    Route::post('/auth/login', 'AuthController@login')->name('login.usuario');
    Route::post('/auth/register', 'AuthController@register')->name('registro.usuario');
    /** OPTIONS */
    Route::get('/options/{name}', 'OptionsController@getByName')->name('busca.metadata.x.nome');
    Route::get('/options', 'OptionsController@list')->name('listar.opcoes');
    /** TAGS */
    Route::get('/tags/{id}', 'TagController@getById')->name('busca.x.tag.id');
    /**  */
    Route::get('/licenses', 'LicenseController@list')->name('listar.licencas');
    /** TOKEN */
    Route::name('verify')->get('usuarios/verify/{token}', 'UserController@verify');
});
/**
 *
 * ROTAS PROTEGIDAS COM JSON WEB TOKEN
 * USUÁRIO DEBE ESTAR LOGADO PARA ACESSAR ESSAS ROTAS
 *
 * */
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
    /** AUTENTICACAO */
    Route::post('/auth/logout', 'AuthController@logout')->name('sair');
    Route::post('/auth/refresh', 'AuthController@refresh')->name('refrescar.token');
    Route::post('/auth/user', 'AuthController@getAuthUser')->name('usuario.logado');
    /** ROLES */
    Route::get('/roles', 'RoleController@list')->name('role.listar');
    /** USUARIOS */
    Route::get('/usuarios/search/{termo}', 'UserController@search')->name('usuario.buscar');
    Route::delete('/usuarios/{id}', 'UserController@delete')->name('usuario.apagar');
    Route::get('/usuarios/{id}', 'UserController@getById')->name('user.x.id');
    Route::get('/usuarios', 'UserController@list')->name('usuario.listar');
    Route::put('/usuarios/{id}', 'UserController@update');
    Route::put('/usuarios/reset-password', 'UserController@resetPass')->name('senha.atualizar');
    Route::post('/usuarios', 'UserController@create')->name('adicionar.usuario');
    /** APLICATIVOS */
    Route::post('/aplicativos', 'AplicativoController@create')->name('aplicativo.adicionar');
    Route::put('/aplicativos/{id}', 'AplicativoController@update')->name('aplicativo.editar');
    Route::delete('/aplicativos/{id}', 'AplicativoController@delete')->name('aplicativo.apagar');
    /** TAGS */
    Route::get('/tags', 'TagController@list')->name('listaTags');
    Route::get('/tags/search/{term}', 'TagController@search')->name('buscaTag');
    Route::post('/tags', 'TagController@create')->name('adicionarTag');
    Route::put('/tags/{id}', 'TagController@update')->name('atualizarTag');
    Route::delete('/tags/{id}', 'TagController@delete')->name('apagarTag');
    /** CONTEUDOS */
    Route::post('/conteudos', 'ConteudoController@create')->name('adicionar.conteudo');
    Route::put('/conteudos/{id}', 'ConteudoController@update')->name('atualizar.conteudo');
    Route::delete('/conteudos/{id}', 'ConteudoController@delete')->name('apagar.conteudo');
    /** CANAIS */
    Route::post('/canais', 'CanalController@create')->name('adicionar.canal');
    Route::put('/canais/{id}', 'CanalController@update')->name('atualizar.canal');
    Route::delete('/canais/{id}', 'CanalController@delete')->name('apagar.canal');
    Route::get('/canais', 'CanalController@list')->name('listar.canais');
    Route::get('/canais/search/{term}', 'CanalController@search')->name('buscar.canal');
    /** LICENCAS */
    Route::get('/licenses/search/{term}', 'LicenseController@search')->name('buscar.licenca');
    Route::post('/licenses', 'LicenseController@create')->name('adicionar.licenca');
    Route::put('/licenses/{id}', 'LicenseController@update')->name('atualizar.licenca');
    Route::delete('/licenses/{id}', 'LicenseController@delete')->name('apagar.licenca');
    /** DENUNCIAS */
    Route::delete('/denuncias/{id}', 'DenunciaController@delete')->name('apagar.denuncias');
    /** OPTIONS */
    Route::post('/options', 'OptionsController@create')->name('criar.opcoes');
    Route::put('/options/{name}', 'OptionsController@update')->name('atualizar.opcoes.x.nome');
    Route::delete('/options/{name}', 'OptionsController@delete')->name('apagar.opcoes.x.nome');
    /** ANALYTICS */
    Route::get('/analytics', 'HomeController@getAnalytics')->name('catalogacao.blog');
});
