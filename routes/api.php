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
Route::get('/files/{id}', 'FileController@getFiles')->name('buscaArquivo');
Route::post('/files/{id}', 'FileController@createFile')->name('adicionaArquivo');

/******
 *
 * Controlador: Category
 * Métodos: list -> Lista das categorias
 */
Route::get('/categories', 'CategoryController@list')->name('listaCategorias');
Route::get('/categories/aplicativos', 'CategoryController@getAplicativoCategories')->name('listaCategoriasAplicativos');

/******
 *
 * Controlador: Tipo
 * Métodos: list -> Lista dos tipos
 */
Route::get('/tipos/conteudos', 'TipoController@list')->name('listar.tipos');

/******
 *
 * Controlador: Denuncia
 * Métodos: adicionar -> Denúncias
 */
Route::get('/denuncias', 'DenunciaController@list')->name('listar.denuncias');
Route::post('/denuncias/create', 'DenunciaController@create')->name('criar.denuncias');

/******
 *
 * Controlador: Fale Cconosco
 * Métodos: enviar -> Fale Conosco
 */
Route::post('/faleconosco/create', 'FaleconoscoController@list')->name('criar.faleconosco');

/******
 *
 * Controlador: Canal
 * Métodos: getBySlug -> Dados do canal pela url amigável
 *
 */
Route::get('/canais/slug/{slug}', 'CanalController@getBySlug')->name('buscar.canal.x.url.amigavel');

/******
 *
 *  Controlador: Conteudo
 * Métodos: list -> Listar conteúdos
 * search -> Buscar conteúdos
 * getById -> Dados do conteúdo pelo id
 * getByTagId -> Lista de conteúdos por Tag
 *
 */
Route::get('/conteudos', 'ConteudoController@list')->name('lista.conteudo');
Route::get('/conteudos/sites', 'ConteudoController@getSitesTematicos')->name('lista.sites.tematicos');
Route::get('/conteudos/search/{term}', 'ConteudoController@search')->name('busca.conteudo');
Route::get('/conteudos/teste', 'ConteudoController@teste');
Route::get('/conteudos/{id}', 'ConteudoController@getById')->name('busca.x.conteudo.id');
Route::get('/conteudos/tag/{id}', 'ConteudoController@getByTagId')->name('busca.x.tag.id');

/******
 *
 * Controlador: Aplicativo
 * Métodos: list -> Lista de aplicativos
 * search -> Busca por nome do aplicativo
 * getById -> Dados do aplicativo por id
 *
 */
Route::get('/aplicativos', 'AplicativoController@list')->name('lista.aplicativo');
Route::get('/aplicativos/search/{term}', 'AplicativoController@search')->name('busca.aplicativo');
Route::get('/aplicativos/{id}', 'AplicativoController@getById')->name('busca.x.aplicativo.id');

/******
 *
 * Controlador: AplicativoCategory
 * Métodos: list -> lista de categorias
 *
 */
Route::get('/aplicativos/categories', 'AplicativoCategoryController@list')->name('lista.categorias.aplicativo');

/******
 *
 * Controlador: Auth
 * Métodos: login -> login do usuário
 * register -> Registro de novo usuário
 *
 */
Route::post('/auth/login', 'AuthController@login')->name('login.usuario');
Route::post('/auth/register', 'AuthController@register')->name('registro.usuario');

/******
 *
 * Controlador: Options
 * Métodos: getByName -> Metadados por nome
 *
 */
Route::get('/options/{name}', 'OptionsController@getByName')->name('busca.metadata.x.nome');
Route::get('/options', 'OptionsController@list')->name('listar.opcoes');
Route::post('/options', 'OptionsController@create')->name('criar.opcoes');
Route::put('/options/{name}', 'OptionsController@update')->name('atualizar.opcoes.x.nome');
Route::delete('/options/{name}', 'OptionsController@delete')->name('apagar.opcoes.x.nome');

/******
 * Controlador: Tag
 * Métodos: getById -> Busca tag por Id
 */
Route::get('/tags/{id}', 'TagController@getById')->name('busca.x.tag.id');

/******
 * Controlador: Licenses
 * Métodos: list -> lista as licenças
 */
Route::get('/licenses', 'LicenseController@list')->name('lista.Licenca');

/******
 *
 * Controlador: Mail
 * Métodos: getSend -> enviar os emails para formulário denúncia e fale conosco
 */
Route::post('/email/enviar', 'DenunciaController@create')->name('denuncia.create');

/******
 *
 * Controlador: Fale Conosco
 * Métodos: getSend -> enviar formulário fale conosco
 */
Route::post('/faleconosco/enviar', 'FaleconoscoController@enviar')->name('faleconosco.enviar');

Route::name('verify')->get('users/verify/{token}', 'UserController@verify');
//Route::get('/users', 'UserController@list')->name('usuario.listar');
//Route::get('/users', 'UserController@list')->name('usuario.listar');

/**
 *
 * ROTAS PROTEGIDAS COM JSON WEB TOKEN
 * USUÁRIO DEBE ESTAR LOGADO PARA ACESSAR ESSAS ROTAS
 *
 * */
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
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
    Route::get('/users/search/{termo}', 'UserController@search')->name('usuario.buscar');
    Route::delete('/users/delete/{id}', 'UserController@delete')->name('usuario.apagar');
    Route::get('/users/{id}', 'UserController@getById')->name('user.x.id');
    Route::get('/users', 'UserController@list')->name('usuario.listar');
    Route::put('/users/{id}', 'UserController@update');
    Route::put('/users/reset-password', 'UserController@resetPass')->name('senha.atualizar');
    Route::post('/users', 'UserController@create')->name('adicionar.usuario');
    /**
     *
     * Controlador: Aplicativo
     * Métodos: Create -> Criar aplicativo
     * update -> Atualizar aplicativo
     * delete -> Deletar aplicativo
     *
     */
    Route::post('/aplicativos/create', 'AplicativoController@create')->name('aplicativo.adicionar');
    Route::put('/aplicativos/update/{id}', 'AplicativoController@update')->name('aplicativo.editar');
    Route::delete('/aplicativos/delete/{id}', 'AplicativoController@delete')->name('aplicativo.apagar');
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
    Route::post('/conteudos/create', 'ConteudoController@create')->name('adicionar.conteudo');
    Route::put('/conteudos/update/{id}', 'ConteudoController@update')->name('atualizar.conteudo');
    Route::delete('/conteudos/delete/{id}', 'ConteudoController@delete')->name('apagar.conteudo');
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
    Route::get('/licenses', 'LicenseController@list')->name('listaLicenca');
    Route::get('/licenses/search/{term}', 'LicenseController@search')->name('buscaLicenca');
    Route::post('/licenses/create', 'LicenseController@create')->name('adicionarLicenca');
    Route::put('/licenses/update/{id}', 'LicenseController@update')->name('atualizarLicenca');
    Route::delete('/licenses/delete/{id}', 'LicenseController@delete')->name('apagarLicenca');
    /**
     *
     * Controlador: Denúncia
     * Métodos: delete -> deletar denúncias
     * delete -> Apagar denúncias
     *
     */
    Route::delete('/denuncias/delete/{id}', 'DenunciaController@delete')->name('apagar.denuncias');
});
