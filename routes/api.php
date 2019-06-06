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
Route::group(['middleware' => ['cors']], function () {

    Route::get('/files/{id}', 'FileController@getFiles')->name('busca.arquivo');
    Route::post('/files/{id}', 'FileController@createFile')->name('adiciona.arquivo');
    Route::get('/destaques', 'HomeController@getHomeData')->name('dados.home');
    Route::get('/layout', 'HomeController@getLayout')->name('lista.links');
    /******
     *
     * Controlador: Category
     * Métodos: list -> Lista das categorias
     */
    Route::get('/categories', 'CategoryController@list')->name('lista.categorias');
    Route::get('/categories/aplicativos', 'CategoryController@getAplicativoCategories')->name('lista.categorias.aplicativos');

    /******
     *
     * Controlador: Tipo
     * Métodos: list -> Lista dos tipos
     */
    Route::get('/tipos', 'TipoController@list')->name('listar.tipos');

    /******
     *
     * Controlador: Denuncia
     * Métodos: adicionar -> Denúncias
     */
    Route::get('/denuncias', 'DenunciaController@list')->name('listar.denuncias');
    Route::post('/denuncias', 'DenunciaController@create')->name('criar.denuncias');

    /******
     *
     * Controlador: Fale Cconosco
     * Métodos: enviar -> Fale Conosco
     */
    Route::post('/faleconosco', 'FaleconoscoController@list')->name('criar.faleconosco');

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
    Route::get('/posts', 'WordpressController@list')->name('lista.postagens');
    Route::get('/posts/estatisticas', 'WordpressController@getEstatisticas')->name('estatisticas.blog');
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

    /******
     * Controlador: Tag
     * Métodos: getById -> Busca tag por Id
     */
    Route::get('/tags/{id}', 'TagController@getById')->name('busca.x.tag.id');

    /******
     * Controlador: Licenses
     * Métodos: list -> lista as licenças
     */
    Route::get('/licenses', 'LicenseController@list')->name('listar.licencas');


    /******
     *
     * Controlador: Fale Conosco
     * Métodos: getSend -> enviar formulário fale conosco
     */
    Route::post('/faleconosco/enviar', 'FaleconoscoController@enviar')->name('faleconosco.enviar');

    Route::name('verify')->get('usuarios/verify/{token}', 'UserController@verify');
    //Route::get('/usuarios', 'UserController@list')->name('usuario.listar');
    //Route::get('/usuarios', 'UserController@list')->name('usuario.listar');
});
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
    Route::post('/auth/refresh', 'AuthController@refresh')->name('refrescar.token');
    Route::post('/auth/user', 'AuthController@getAuthUser')->name('usuario.logado');
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
    Route::get('/usuarios/search/{termo}', 'UserController@search')->name('usuario.buscar');
    Route::delete('/usuarios/{id}', 'UserController@delete')->name('usuario.apagar');
    Route::get('/usuarios/{id}', 'UserController@getById')->name('user.x.id');
    Route::get('/usuarios', 'UserController@list')->name('usuario.listar');
    Route::put('/usuarios/{id}', 'UserController@update');
    Route::put('/usuarios/reset-password', 'UserController@resetPass')->name('senha.atualizar');
    Route::post('/usuarios', 'UserController@create')->name('adicionar.usuario');
    /**
     *
     * Controlador: Aplicativo
     * Métodos: Create -> Criar aplicativo
     * update -> Atualizar aplicativo
     * delete -> Deletar aplicativo
     *
     */
    Route::post('/aplicativos', 'AplicativoController@create')->name('aplicativo.adicionar');
    Route::put('/aplicativos/{id}', 'AplicativoController@update')->name('aplicativo.editar');
    Route::delete('/aplicativos/{id}', 'AplicativoController@delete')->name('aplicativo.apagar');
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
    Route::post('/tags', 'TagController@create')->name('adicionarTag');
    Route::put('/tags/{id}', 'TagController@update')->name('atualizarTag');
    Route::delete('/tags/{id}', 'TagController@delete')->name('apagarTag');
    /**
     *
     * Controlador: Conteudo
     * Métodos: create -> Adicionar novo conteúdo
     * update -> Atualizar conteúdo
     * delete -> Apagar conteúdo
     *
     */
    Route::post('/conteudos', 'ConteudoController@create')->name('adicionar.conteudo');
    Route::put('/conteudos/{id}', 'ConteudoController@update')->name('atualizar.conteudo');
    Route::delete('/conteudos/{id}', 'ConteudoController@delete')->name('apagar.conteudo');
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
    Route::post('/canais', 'CanalController@create')->name('adicionar.canal');
    Route::put('/canais/{id}', 'CanalController@update')->name('atualizar.canal');
    Route::delete('/canais/{id}', 'CanalController@delete')->name('apagar.canal');
    Route::get('/canais', 'CanalController@list')->name('listar.canais');
    Route::get('/canais/search/{term}', 'CanalController@search')->name('buscar.canal');
    /**
     *
     * Controlador: License
     * Métodos: list -> Lista das licenças
     * create -> Adicionar licença
     * update -> Atualizar licença
     * delete -> Apagar licença
     *
     */
    Route::get('/licenses/search/{term}', 'LicenseController@search')->name('buscar.licenca');
    Route::post('/licenses', 'LicenseController@create')->name('adicionar.licenca');
    Route::put('/licenses/{id}', 'LicenseController@update')->name('atualizar.licenca');
    Route::delete('/licenses/{id}', 'LicenseController@delete')->name('apagar.licenca');
    /**
     *
     * Controlador: Denúncia
     * Métodos: delete -> deletar denúncias
     * delete -> Apagar denúncias
     *
     */
    Route::delete('/denuncias/{id}', 'DenunciaController@delete')->name('apagar.denuncias');
    /**
     * Controlador: Options
     * Metodos :
     * create -> Adicionar opção
     * update -> Atualizar opção por nome
     * delete -> Apagar opcão por nome
     */
    Route::post('/options', 'OptionsController@create')->name('criar.opcoes');
    Route::put('/options/{name}', 'OptionsController@update')->name('atualizar.opcoes.x.nome');
    Route::delete('/options/{name}', 'OptionsController@delete')->name('apagar.opcoes.x.nome');
});
