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

/******
 *
 * Controlador: File
 * Métodos: getFiles -> Lista dos arquivos relacionados a um id específico
 * createFile -> Adiciona um novo arquivo para um recurso específico
 */
Route::get('/file/{id}', 'FileController@getFiles')->name('buscaArquivo');
Route::post('/file/{id}', 'FileController@createFile')->name('adicionaArquivo');

/******
 *
 * Controlador: Category
 * Métodos: list -> Lista das categorias
 */
Route::get('/categories', 'CategoryController@list')->name('listaCategorias');

/******
 *
 * Controlador: Canal
 * Métodos: getBySlug -> Dados do canal pela url amigável
 *
 */
Route::get('/canais/slug/{slug}', 'CanalController@getBySlug')->name('buscaCanalxUrlAmigavel');
/******
 *
 *  Controlador: Conteudo
 * Métodos: list -> Listar conteúdos
 * search -> Buscar conteúdos
 * getById -> Dados do conteúdo pelo id
 * getByTagId -> Lista de conteúdos por Tag
 *
 */
Route::get('/conteudos', 'ConteudoController@list')->name('listaConteudo');
Route::get('/conteudos/sites', 'ConteudoController@getSitesTematicos')->name('listaSitesTematicos');
Route::get('/conteudos/search/{term}', 'ConteudoController@search')->name('buscaConteudo');
Route::get('/conteudos/teste', 'ConteudoController@teste');
Route::get('/conteudos/{id}', 'ConteudoController@getById')->name('buscaxConteudoId');
Route::get('/conteudos/tag/{id}', 'ConteudoController@getByTagId')->name('buscaxTagId');
/******
 *
 * Controlador: Aplicativo
 * Métodos: list -> Lista de aplicativos
 * search -> Busca por nome do aplicativo
 * getById -> Dados do aplicativo por id
 *
 */
Route::get('/aplicativos', 'AplicativoController@list')->name('listaAplicativo');
Route::get('/aplicativos/search/{term}', 'AplicativoController@search')->name('buscaAplicativo');
Route::get('/aplicativos/{id}', 'AplicativoController@getById')->name('buscaxAplicativoId');
/******
 *
 * Controlador: Auth
 * Métodos: login -> login do usuário
 * register -> Registro de novo usuário
 *
 */
Route::post('/auth/login', 'AuthController@login')->name('loginUsuario');
Route::post('/auth/register', 'AuthController@register')->name('registroUsuario');
Route::post('/auth/update', 'AuthController@update')->name('updateUsuario');
/******
 *
 * Controlador: Options
 * Métodos: getByName -> Metadados por nome
 *
 */
Route::post('options/name/{name}', 'OptionsController@getByName')->name('buscaMetaDataxNome');
/******
* Controlador: Tag
* Métodos: getById -> Busca tag por Id
*/
Route::get('/tags/{id}', 'TagController@getById')->name('buscaxTagId');




/**
 *
 * ROTAS PROTEGIDAS COM JSON WEB TOKEN
 * USUÁRIO DEBE ESTAR LOGADO PARA ACESSAR ESSAS ROTAS
 *
 * */
Route::group(['middleware' => ['jwt.verify']], function () {
    /**
     *
     * Controlador: Auth
     * Métodos: logout -> Sair,
     * refresh -> Refrescar token,
     * getAuthUser -> Dados do usuário logado
     *
     */
    Route::post('/auth/logout', 'AuthController@logout')->name('sair');
    Route::post('/auth/refresh', 'AuthController@refresh')->name('refrescarToken');
    Route::post('/auth/user', 'AuthController@getAuthUser')->name('usuarioLogado');
    /**
     *
     * Controlador: User
     * Métodos: search - > Busca por nome do usuário
     * delete -> Deletar usuário por id
     * getById -> Dados do usuário por id
     * list -> Lista de usuários
     * resetPass -< Resetar senha
     *
     */
    Route::get('/users/search/{term}', 'UserController@search')->name('buscarUsuario');
    Route::delete('/users/delete/{id}', 'UserController@delete')->name('apagarUsuario');
    Route::delete('/users/{id}', 'UserController@getById')->name('buscaxUsuarioId');
    Route::get('/users', 'UserController@list')->name('listaUsuario');
    Route::put('/users/reset_pass', 'UserController@resetPass')->name('atualizarSenha');
    /**
     *
     * Controlador: Aplicativo
     * Métodos: Create -> Criar aplicativo
     * update -> Atualizar aplicativo
     * delete -> Deletar aplicativo
     *
     */
    Route::post('/aplicativos/create', 'AplicativoController@create')->name('adicionarAplicativo');
    Route::put('/aplicativos/update/{id}', 'AplicativoController@update')->name('atualizarAplicativo');
    Route::delete('/aplicativos/delete/{id}', 'AplicativoController@delete')->name('apagarAplicativo');
    /**
     *
     * Controllador: Tags
     * Métodos: list -> Listar tags
     * search -> Buscar tags pelo termo de busca
     * create -> Adicionar nova tag
     * update -> Atualizar tag
     * delete -> Apagar tag
     *
     */
    Route::get('/tags', 'TagController@list')->name('listaTags');
    Route::get('/tags/search/{term}', 'TagController@search')->name('buscaTag');
    Route::post('/tags/create', 'TagController@create')->name('adicionarTag');
    Route::put('/tags/update/{id}', 'TagController@update')->name('atualizarTag');
    Route::delete('/tags/delete/{id}', 'TagController@delete')->name('apagarTag');
    /**
     *
     * Controlador: Conteudo
     * Métodos: create -> Adicionar novo conteúdo
     * update -> Atualizar conteúdo
     * delete -> Apagar conteúdo
     *
     */
    Route::post('/conteudos/create', 'ConteudoController@create')->name('adicionarConteudo');
    Route::put('/conteudos/update/{id}', 'ConteudoController@update')->name('atualizarConteudo');
    Route::delete('/conteudos/delete/{id}', 'ConteudoController@delete')->name('apagarConteudo');
    /**
     *
     * Controlador: Canal
     * Métodos: create -> Adicionar Canal
     * update -> Atualizar Canal
     * delete -> Apagar Canal
     * list -> Listar Canais
     * search -> Buscar canal pelo nome
     *
     */
    Route::post('/canais/create', 'CanalController@create')->name('adicionarCanal');
    Route::put('/canais/update/{id}', 'CanalController@update')->name('atualizarCanal');
    Route::delete('/canais/delete/{id}', 'CanalController@delete')->name('apagarCanal');
    Route::get('/canais', 'CanalController@list')->name('listaCanal');
    Route::get('/canais/search/{term}', 'CanalController@search')->name('adicionarCanal');
    /**
     *
     * Controlador: License
     * Métodos: list -> Lista das licenças
     * create -> Adicionar licença
     * update -> Atualizar licença
     * delete -> Apagar licença
     *
     */
    Route::get('/licencas', 'LicenseController@list')->name('listaLicenca');
    Route::get('/licencas/search/{term}', 'LicenseController@search')->name('buscaLicenca');
    Route::post('/licencas/create', 'LicenseController@create')->name('adicionarLicenca');
    Route::put('/licencas/update/{id}', 'LicenseController@update')->name('atualizarLicenca');
    Route::delete('/licencas/delete/{id}', 'LicenseController@delete')->name('apagarLicenca');
});
