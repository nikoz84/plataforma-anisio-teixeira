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
    Route::get('/categories', 'CategoryController@index')->name('lista.categorias');
    Route::get('/categories/{id}', 'CategoryController@getCategoryById')->name('lista.categoria.x.id');
    /** APLICATIVOS CATEGORIAS */
    Route::get('/aplicativos/categories', 'AplicativoCategoryController@index')->name('lista.categorias.aplicativo');
    Route::get('/aplicativos/categories/{id}', 'AplicativoCategoryController@getAplicativoCategories')
        ->name('lista.categorias.aplicativos');
    /** TIPOS */
    Route::get('/tipos', 'TipoController@index')->name('listar.tipos');
    Route::get('/tipos/{id}', 'TipoController@getTiposById')->name('lista.tipos.x.id');
    /** DENUNCIA E FALE CONOSCO */
    Route::get('/denuncias', 'DenunciaController@index')->name('listar.denuncias');
    Route::post('/denuncias', 'DenunciaController@create')->name('criar.denuncias');
    Route::post('/faleconosco', 'FaleconoscoController@create')->name('criar.faleconosco');
    /** CANAIS */
    Route::get('/canais/slug/{slug}', 'CanalController@getBySlug')->name('buscar.canal.x.url.amigavel');
    /** CONTEUDOS */
    Route::get('/conteudos', 'ConteudoController@index')->name('lista.conteudo');
    Route::get('/conteudos/sites', 'ConteudoController@getSitesTematicos')->name('lista.sites.tematicos');
    Route::get('/conteudos/search/{term}', 'ConteudoController@search')->name('busca.conteudo');
    Route::get('/conteudos/teste', 'ConteudoController@teste');
    Route::get('/conteudos/{id}', 'ConteudoController@getById')->name('busca.x.conteudo.id');
    Route::get('/conteudos/tag/{id}', 'ConteudoController@getByTagId')->name('busca.x.tag.id');
    /** BLOG */
    Route::get('/posts', 'WordpressController@index')->name('lista.postagens');
    Route::get('/posts/estatisticas', 'WordpressController@getEstatisticas')->name('estatisticas.blog');
    /** APLICATIVOS */
    Route::get('/aplicativos', 'AplicativoController@index')->name('lista.aplicativo');
    Route::get('/aplicativos/search/{term}', 'AplicativoController@search')->name('busca.aplicativo');
    Route::get('/aplicativos/{id}', 'AplicativoController@getById')->name('busca.x.aplicativo.id');
    /** AUTENTICACAO */
    Route::post('/auth/login', 'AuthController@login')->name('login.usuario');
    Route::post('/auth/register', 'AuthController@register')->name('registro.usuario');
    /** OPTIONS  */
    Route::get('/options/{name}', 'OptionsController@getByName')->name('busca.metadata.x.nome');
    Route::get('/options', 'OptionsController@index')->name('listar.opcoes');
    /** TAGS */
    Route::get('/tags/{id}', 'TagController@getById')->name('busca.x.tag.id');
    Route::get('/tags/autocomplete/{term}', 'TagController@autocomplete')->name('autocompletar.tag');
    /**  */
    Route::get('/licencas', 'LicenseController@index')->name('listar.licencas');
    /** TOKEN */
    Route::name('verify')->get('usuarios/verify/{token}', 'UserController@verify');
});
/**
 *
 * ROTAS PROTEGIDAS COM JSON WEB TOKEN
 * USUÁRIO DEVE ESTAR LOGADO PARA ACESSAR ESSAS ROTAS
 *
 * */
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
    /** CATEGORIAS DOS CONTEÚDOS*/
    Route::post('/categories', 'CategoryController@create')->name('criar.categorias');
    // ->middleware('isAdmin');
    Route::put('/categories/{id}', 'CategoryController@update')->name('atualizar.categorias');
    Route::delete('/categories/{id}', 'CategoryController@delete')->name('categorias.apagar');
    /** APLICATIVOS CATEGORIAS */
    Route::post('/aplicativos/categories', 'AplicativoCategoryController@create')->name('criar.aplicativo.categorias');
    Route::put('/aplicativos/categories/{id}', 'AplicativoCategoryController@update')
        ->name('atualizar.aplicativo.categorias');
    Route::delete('/aplicativos/categories/{id}', 'AplicativoCategoryController@delete')
        ->name('apagar.aplicativo.categorias');
    /** AUTENTICACAO */
    Route::post('/auth/logout', 'AuthController@logout')->name('sair');
    Route::post('/auth/refresh', 'AuthController@refresh')->name('refrescar.token');
    Route::post('/auth/user', 'AuthController@getAuthUser')->name('usuario.logado');
    /** TIPOS */
    Route::post('/tipos', 'TipoController@create')->name('criar.tipos');
    Route::put('/tipos/{id}', 'TipoController@update')->name('atualizar.tipos');
    /** ROLES */
    Route::get('/roles', 'RoleController@index')->name('role.listar');
    //->middleware(['isAdmin', 'isSuperAdmin']);
    Route::post('/roles', 'RoleController@create')->name('criar.role');
    Route::put('/roles/{id}', 'RoleController@update')->name('atualizar.role');
    Route::delete('/roles/{id}', 'RoleController@delete')->name('deletar.role');
    Route::get('/roles/search/{term}', 'RoleController@search')->name('busca.role');
    /** USUARIOS */
    Route::get('/usuarios/search/{termo}', 'UserController@search')->name('usuario.buscar');
    Route::delete('/usuarios/{id}', 'UserController@delete')->name('usuario.apagar');
    Route::get('/usuarios/{id}', 'UserController@getById')->name('user.x.id');
    Route::get('/usuarios', 'UserController@index')->name('usuario.listar');
    Route::put('/usuarios/{id}', 'UserController@update');
    Route::put('/usuarios/reset-password', 'UserController@resetPass')->name('senha.atualizar');
    Route::post('/usuarios', 'UserController@create')->name('adicionar.usuario');
    /** APLICATIVOS */
    Route::post('/aplicativos', 'AplicativoController@create')->name('aplicativo.adicionar');
    Route::put('/aplicativos/{id}', 'AplicativoController@update')->name('aplicativo.editar');
    Route::delete('/aplicativos/{id}', 'AplicativoController@delete')->name('aplicativo.apagar');
    /** TAGS */
    Route::get('/tags', 'TagController@index')->name('listaTags');
    Route::post('/tags', 'TagController@create')->name('adicionarTag');
    Route::get('/tags/search/{term}', 'TagController@search')->name('buscaTag');
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
    Route::get('/canais', 'CanalController@index')->name('listar.canais');
    Route::get('/canais/search/{term}', 'CanalController@search')->name('buscar.canal');
    /** LICENCAS */
    Route::get('/licencas/search/{term}', 'LicenseController@search')->name('buscar.licenca');
    Route::post('/licencas', 'LicenseController@create')->name('adicionar.licenca');
    Route::put('/licencas/{id}', 'LicenseController@update')->name('atualizar.licenca');
    Route::delete('/licencas/{id}', 'LicenseController@delete')->name('apagar.licenca');
    /** DENUNCIAS */
    Route::delete('/denuncias/{id}', 'DenunciaController@delete')->name('apagar.denuncias');
    /** OPTIONS */
    Route::post('/options', 'OptionsController@create')->name('criar.opcoes');
    Route::put('/options/{name}', 'OptionsController@update')->name('atualizar.opcoes.x.nome');
    Route::delete('/options/{name}', 'OptionsController@delete')->name('apagar.opcoes.x.nome');
    /** ANALYTICS */
    Route::get('/analytics', 'HomeController@getAnalytics')->name('catalogacao.blog.e.plataforma');
});
