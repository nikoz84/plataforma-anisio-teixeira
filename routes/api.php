<?php

use Illuminate\Support\Facades\Route;

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

    Route::get('/ler', 'ConteudoController@lerHD')->name('ler.hd');
    Route::get('/files/galeria', 'FileController@getGallery')->name('lista.galeria.imagens');
    Route::get('/files/{id}', 'FileController@getFiles')->name('busca.arquivo');
    Route::post('/files/{id}', 'FileController@createFile')->name('adiciona.arquivo');
    Route::get('/autocompletar', 'HomeController@autocomplete')->name('autocompletar.home');
    Route::get('/layout', 'HomeController@getLayout')->name('lista.links');
    /** CATEGORIAS */
    Route::get('/categorias', 'CategoryController@index')->name('lista.categorias');
    Route::get('/categorias/{id}', 'CategoryController@getCategoryById')->name('lista.categoria.x.id');
    Route::get('/categorias/canal/{id}', 'CategoryController@getCategoryByCanalId')->name('lista.categoria.x.canal.id');
    /** TIPOS */
    Route::get('/tipos', 'TipoController@index')->name('listar.tipos');
    Route::get('/tipos/{id}', 'TipoController@getTiposById')->name('lista.tipos.x.id');
    /** DENUNCIA E FALE CONOSCO */
    Route::post('/contato', 'ContatoController@create')->name('criar.faleconosco.contato');
    /** CANAIS */
    Route::get('/canais/slug/{slug}', 'CanalController@getBySlug')->name('buscar.canal.x.url.amigavel');
    /** COMPONENTES */
    Route::get('/componentes', 'ComponentesController@index')->name('lista.componentes.curriculares');
    /** CONTEUDOS */
    Route::get('/conteudos', 'ConteudoController@index')->name('lista.conteudo');
    Route::get('/conteudos/sites', 'ConteudoController@getSitesTematicos')->name('lista.sites.tematicos');
    Route::get('/conteudos/search/{term}', 'ConteudoController@search')->name('busca.conteudo');
    Route::get('/conteudos/{id}', 'ConteudoController@getById')->name('busca.x.conteudo.id');
    Route::get('/conteudos/tag/{id}', 'ConteudoController@getByTagId')->name('busca.x.tag.id');
    Route::get('/conteudos/relacionados/{id}', 'ConteudoController@conteudosRelacionados')->name('busca.x.id');

    /** BLOG */
    Route::get('/posts', 'WordpressController@index')->name('lista.postagens');
    Route::get('/posts/{id}', 'WordpressController@getById')->name('busca.postagen.x.id');
    Route::get('/posts/estatisticas', 'WordpressController@getEstatisticas')->name('estatisticas.blog');
    /** APLICATIVOS */
    Route::get('/aplicativos', 'AplicativoController@index')->name('lista.aplicativo');
    Route::get('/aplicativos/categories', 'AplicativoCategoryController@index')->name('lista.categorias');
    Route::get('/aplicativos/search/{term}', 'AplicativoController@search')->name('busca.aplicativo');
    Route::get('/aplicativos/{id}', 'AplicativoController@getById')->name('busca.x.aplicativo.id');
    /** AUTENTICACAO */
    Route::post('/auth/login', 'AuthController@login')->name('login.usuario');
    
    Route::post('/auth/cadastro', 'AuthController@register')->name('registro.usuario');
    Route::get('/auth/verificar/{token}', 'AuthController@verifyToken')->name('verificar.token');
    Route::post('/auth/recuperar-senha', 'AuthController@recoverPass')->name('recuperar.senha');

    Route::get('/auth/verificar/email/{token}', 'AuthController@verifyTokenUserRegister')
    ->name('verificar.usuario.token');
    /** OPTIONS  */
    Route::get('/options/{name}', 'OptionsController@getByName')->name('busca.metadata.x.nome');
    Route::get('/options', 'OptionsController@index')->name('listar.opcoes');
    /** TAGS */
    Route::get('/tags/{id}', 'TagController@getById')->name('busca.x.tag.id');
    /** LICENÇAS */
    Route::get('/licencas', 'LicenseController@index')->name('listar.licencas');
    /** DOWNLOAD FILE **/
    Route::get('/files/{action}/{id}', 'FileController@downloadFile')->name('downloadFile.id');
    
    /** CONTEUDO PLANILHA **/
    Route::get('/planilha/buscar/faculdades/da/bahia/{googleKey}', 
        'ConteudoPlanilhaController@buscarJsonFaculdadesDaBahiaNoGoogleSpreadsheets')->name('busca.planilha');

    Route::get('/planilha/buscar/rotina/de/estudos/{googleKey}', 
        'ConteudoPlanilhaController@buscarJsonRotinaDeEstudosNoGoogleSpreadsheets')
    ->name('busca.planilha.rotina.de.estudos');

    Route::get('/planilhas', 'ConteudoPlanilhaController@conteudos')->name('conteudo.planilha');
    

/**
 *
 * ROTAS PROTEGIDAS COM JSON WEB TOKEN
 * USUÁRIO DEVE ESTAR LOGADO PARA ACESSAR ESSAS ROTAS
 *
 * */
Route::group(['middleware' => ['jwt.auth']], function () {
    /** CATEGORIAS DOS CONTEÚDOS*/
    Route::post('/categorias', 'CategoryController@create')->name('criar.categorias');
    Route::put('/categorias/{id}', 'CategoryController@update')->name('atualizar.categorias');
    Route::delete('/categorias/{id}', 'CategoryController@delete')->name('categorias.apagar');
    /** AUTENTICACAO */
    Route::post('/auth/logout', 'AuthController@logout')->name('sair');
    Route::post('/auth/refresh', 'AuthController@refresh')->name('refrescar.token');
    Route::get('/auth/links-admin', 'AuthController@linksAdmin')->name('links.admin');
    /** TIPOS */
    Route::post('/tipos', 'TipoController@create')->name('criar.tipos');
    Route::put('/tipos/{id}', 'TipoController@update')->name('atualizar.tipos');
    /** ROLES */
    Route::get('/roles', 'RoleController@index')->name('role.listar');
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
    /** APLICATIVOS CATEGORIES */
    Route::post('/aplicativos/categories', 'AplicativoCategoryController@create')->name('criar.aplicativo.categorias');
    Route::put('/aplicativos/categories/{id}', 'AplicativoCategoryController@update')
        ->name('atualizar.aplicativo.categorias');
    Route::delete('/aplicativos/categories/{id}', 'AplicativoCategoryController@delete')
        ->name('apagar.aplicativo.categorias');
    /** TAGS */
    Route::get('/tags', 'TagController@index')->name('lista.tag');
    Route::post('/tags', 'TagController@create')->name('adicionar.tag');
    Route::get('/tags/search/{term}', 'TagController@search')->name('busca.tag');
    Route::get('/tags/autocomplete/{term}', 'TagController@autocomplete')->name('autocompletar.tag');
    Route::put('/tags/{id}', 'TagController@update')->name('atualizar.tag');
    Route::delete('/tags/{id}', 'TagController@delete')->name('apagar.tag');
    /** CONTEUDOS */
    Route::post('/conteudos', 'ConteudoController@create')->name('adicionar.conteudo');
    Route::put('/conteudos/{id}', 'ConteudoController@update')->name('atualizar.conteudo');
    Route::delete('/conteudos/{id}', 'ConteudoController@delete')->name('apagar.conteudo');
    Route::post('/conteudos/arquivos', 'ConteudoController@storeFiles')->name('salvar.arquivo.conteudo');
    /** CANAIS */
    Route::get('/canais', 'CanalController@index')->name('listar.canais');
    Route::post('/canais', 'CanalController@create')->name('adicionar.canal');
    Route::put('/canais/{id}', 'CanalController@update')
        ->name('atualizar.canal')
        ->middleware('can:update,canal');
    Route::delete('/canais/{id}', 'CanalController@delete')->name('apagar.canal');
    Route::get('/canais/{id}', 'CanalController@getById')->name('listar.canal.x.id');
    Route::get('/canais/search/{term}', 'CanalController@search')->name('buscar.canal');
    /** LICENCAS */
    Route::get('/licencas/search/{term}', 'LicenseController@search')->name('buscar.licenca');
    Route::post('/licencas', 'LicenseController@create')->name('adicionar.licenca');
    Route::put('/licencas/{id}', 'LicenseController@update')->name('atualizar.licenca');
    Route::delete('/licencas/{id}', 'LicenseController@delete')->name('apagar.licenca');
    /** DENUNCIAS */
    Route::get('/contato', 'ContatoController@index')->name('listar.faleconosco');
    Route::get('/contato/{id}', 'ContatoController@getById')->name('busca.x.id');
    Route::delete('/contato/{id}', 'ContatoController@delete')->name('apagar.contato');
    /** OPTIONS */
    Route::post('/options', 'OptionsController@create')->name('criar.opcoes');
    Route::put('/options/{name}', 'OptionsController@update')->name('atualizar.opcoes.x.nome');
    Route::delete('/options/{name}', 'OptionsController@delete')->name('apagar.opcoes.x.nome');
    Route::post('/options/destaques/', 'OptionsController@createDestaques')->name('cria.destaques');
    Route::get('/options/id/{id}', 'OptionsController@getById')->name('opcao.x.id');
    /** ANALYTICS */
    Route::get('/analytics', 'HomeController@getAnalytics')->name('catalogacao.blog.e.plataforma');
    /** RELATÓRIOS */
    Route::get('/usuarios/role/{role_id}', 'RelatorioController@buscarUsuariosPorRole')->name('view.relatorio.usuario');
    Route::get('/relatorio/conteudos/{flag}', 'RelatorioController@gerarPdfConteudo')->name('gerar.relatorio.conteudo');
    Route::get('/relatorio/usuarios/role/{role_id}/{is_active?}', 'RelatorioController@gerarPdfUsuario')->name('gerar.relatorio.usuario');
});
