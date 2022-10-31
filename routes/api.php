<?php

use App\Http\Controllers\AplicativoCategoryController;
use App\Http\Controllers\AplicativoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CanalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ComponentesController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\ConteudoController;
use App\Http\Controllers\ConteudoLikeController;
use App\Http\Controllers\CurricularComponentCategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\NivelEnsinoController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\PlayListController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WordpressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/** FILE */
Route::group(['prefix' => 'files', 'as' => 'files.'], function () {
    Route::get('/galeria', [FileController::class, 'getGallery'])->name('lista.galeria.imagens');
    Route::get('/{id}', [FileController::class, 'getFiles'])->name('busca');
    //Route::post('/{id}', [FileController::class, 'createFile'])->name('adiciona');
});
/** HOME */
Route::get('/autocompletar', [HomeController::class, 'autocomplete'])->name('autocompletar.home');
Route::get('/layout', [HomeController::class, 'getLayout'])->name('lista.links');

/** CATEGORIAS */
Route::group(['prefix' => 'categorias', 'as' => 'categorias.'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('lista');
    Route::get('/{id}', [CategoryController::class, 'getById'])->name('x.id');
    Route::get('/canal/{id}', [CategoryController::class, 'getCategoryByCanalId'])->name('lista.x.canal.id');
    Route::get('/search/{term}', [CategoryController::class, 'search'])->name('autocompletar');
});
/** TIPOS */
Route::group(['prefix' => 'tipos', 'as' => 'tipos.'], function () {
    Route::get('/', [TipoController::class, 'index'])->name('listar');
    Route::get('/{id}', [TipoController::class, 'getTiposById'])->name('x.id');
    Route::get('/search/{term}', [TipoController::class, 'search'])->name('autocompletar');
});
/** DENUNCIA E FALE CONOSCO */
Route::post('/contato', [ContatoController::class, 'create'])->name('criar.faleconosco.contato');

/** CANAIS */
Route::get('/canais/slug/{slug}', [CanalController::class, 'getBySlug'])->name('buscar.canal.x.url.amigavel');

/** COMPONENTES */
Route::get('/componentes', [ComponentesController::class, 'index'])->name('lista.componentes.curriculares');

/** CATEGORIAS COMPONENTES */
Route::group(['prefix' => 'componentescategorias', 'as' => 'cc.categorias.'], function () {
    Route::get('/', [CurricularComponentCategoryController::class, 'index'])->name('listar');
    Route::get('/search/{termo}', [CurricularComponentCategoryController::class, 'search'])->name('autocompletar');
    Route::get('/{id}', [CurricularComponentCategoryController::class, 'getById'])->name('x.id');
});

/**NIVEL ENSINO**/
Route::get('/nivelensino', [NivelEnsinoController::class, 'index'])->name('lista.nevelensino');

/** CONTEUDOS */
Route::group(['prefix' => 'conteudos', 'as' => 'conteudos.'], function () {
    Route::get('/', [ConteudoController::class, 'index'])->name('listar');
    Route::get('/sites', [ConteudoController::class, 'getSitesTematicos'])->name('listar.sites.tematicos');
    Route::get('/search/{term}', [ConteudoController::class, 'search'])->name('autocompletar');
    Route::get('/{id}', [ConteudoController::class, 'getById'])->name('x.id');
    Route::get('/tag/{id}', [ConteudoController::class, 'getByTagId'])->name('x.tag.id');
    Route::get('/relacionados/{id}', [ConteudoController::class, 'conteudosRelacionados'])->name('relacionados.x.id');
    Route::get('/streaming/nofiles', [ConteudoController::class, 'conteudoWithNoStreamingFiles'])->name('nostreamingfiles');
    Route::get('/destaques/{slug}', [ConteudoController::class, 'getConteudosRecentes'])->name('recentes');
});
/** BLOG */
Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
    Route::get('/', [WordpressController::class, 'index'])->name('listar');
    Route::get('/{id}', [WordpressController::class, 'getById'])->name('x.id');
    Route::get('/estatisticas', [WordpressController::class, 'getEstatisticas'])->name('estatisticas');
});
/** APLICATIVOS */
Route::group(['prefix' => 'aplicativos', 'as' => 'aplicativos.'], function () {
    Route::get('/', [AplicativoController::class, 'index'])->name('listar');
    Route::get('/categories', [AplicativoCategoryController::class, 'index'])->name('listar.categorias');
    Route::get('/search/{term}', [AplicativoController::class, 'search'])->name('autocomplete');
    Route::get('/{id}', [AplicativoController::class, 'getById'])->name('x.id');
});
/** AUTENTICACAO */
Route::group(['prefix' => 'auth', 'as' => 'auth.usuario.'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/cadastro', [AuthController::class, 'register'])->name('registro');
    Route::get('/verificar/{token}', [AuthController::class, 'verifyToken'])->name('verificar.token');
    Route::post('/recuperar-senha', [AuthController::class, 'recoverPass'])->name('recuperar.senha');
    Route::post('/modificar-senha/{token} ', [AuthController::class, 'modificarSenha'])->name('modificar.senha');
    Route::get('/verificar/email/{token}', [AuthController::class, 'verifyTokenUserRegister'])->name('verificar.usuario.token');
});
/** OPTIONS  */
Route::group(['prefix' => 'options', 'as' => 'options.'], function () {
    Route::get('/{name}', [OptionsController::class, 'getByName'])->name('busca.x.nome');
    Route::get('/', [OptionsController::class, 'index'])->name('listar');
});
/** TAGS */
Route::get('/tags/{id}', [TagController::class, 'getById'])->name('busca.x.tag');
/** LICENÇAS */
Route::get('/licencas', [LicenseController::class, 'index'])->name('listar.licencas');
/** DOWNLOAD FILE **/
Route::get('/files/{directory}/{id}', [FileController::class, 'downloadFile'])->name('downloadFile.id');

/**LIKES - DISLIKES */
Route::get('/likes/count/{conteudoid}/{tipo}', [ConteudoLikeController::class, 'getLikesByConteudoAplicativo'])->name('likes.conteudo');

//Route::get('/planilhas/load-rotinas/','ConteudoPlanilhaController@getRotinaDeEstudos')->name('busca.rotina.de.estudos');
//Route::get('/planilhas/load-faculdades/', 'ConteudoPlanilhaController@getFaculdadesDaBahia')->name('busca.faculdades');

Route::get('/planilhas', [DocumentController::class, 'getDocumentByName'])->name('docs.planilhas');

Route::get('/rotinas/{nivel}/{semana}', [DocumentController::class, 'rotinasPerNivel'])->name('rotinas.estudos.x.nivel');

Route::group(['prefix' => 'canal-at', 'as' => 'canal-at.'], function () {
    Route::get('/', [DocumentController::class, 'getCanalAT'])->name('info');
    Route::get('/podcast', [DocumentController::class, 'getPodcastAT'])->name('podcast');
});

Route::group(
    ['prefix' => 'playlist', 'as' => 'playlist.'],
    function () {
        Route::get('/', [PlayListController::class, 'index'])->name('listar');
        Route::post('/', [PlayListController::class, 'create'])->name('adicionar');
        Route::get('/search/{term}', [PlayListController::class, 'search'])->name('search');
        Route::get('/adicionar/item/{id}', [PlayListController::class, 'addToPlaylist'])->name('add');
        Route::delete('/remover/item/{id}', [PlayListController::class, 'removeToPlayList'])->name('remove');
        Route::put('/atualizar/item/{id}', [PlayListController::class, 'updatePlayList'])->name('update');
        Route::get('/name/{name}', [PlayListController::class, 'getByName'])->name('ByName');
        Route::get('/{id}', [PlayListController::class, 'getById'])->name('ByID');
    }
);
/*
Route::get('/postagens', function(){
    $postagens =  \App\Models\Wordpress\Post::all();

    return response()->json($postagens);
});
*/
Route::get('/postagens/search/{term}', [WordpressController::class, 'search']);

/***********************************************
 *
 * ROTAS PROTEGIDAS COM JSON WEB TOKEN
 * USUÁRIO DEVE ESTAR LOGADO PARA ACESSAR ESSAS ROTAS
 *
 ********************************************************/

Route::group(
    ['middleware' => ['jwt.auth', 'cors'], 'as' => 'auth.'],
    function () {
        /** CATEGORIAS DOS CONTEÚDOS*/
        Route::group(['prefix' => 'categorias', 'as' => 'categorias.'], function () {
            Route::post('/', [CategoryController::class, 'create'])->name('criar');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('atualizar');
            Route::delete('/{id}', [CategoryController::class, 'delete'])->name('deletar');
        });

        /** COMPONENTES */
        Route::group(['prefix' => 'componentes', 'as' => 'componentes.'], function () {
            Route::post('/', [ComponentesController::class, 'create'])->name('criar');
            Route::get('/{id}', [ComponentesController::class, 'getById'])->name('x.id');
            Route::put('/{id}', [ComponentesController::class, 'update'])->name('atualizar');
            Route::get('/search/{termo}', [ComponentesController::class, 'search'])->name('search');
            Route::get('/autocomplete/{term}', [ComponentesController::class, 'autocomplete'])->name('autocompletar');
            Route::delete('/{id}', [ComponentesController::class, 'delete'])->name('deletar');
        });

        /** COMPONENTES CATEGORIAS*/
        Route::group(['prefix' => 'componentescategorias', 'cc.categorias.'], function () {
            Route::post('/', [CurricularComponentCategoryController::class, 'create'])->name('criar');
            Route::put('/{id}', [CurricularComponentCategoryController::class, 'update'])->name('atualizar');
            Route::delete('/{id}', [CurricularComponentCategoryController::class, 'delete'])->name('deletar');
            Route::get('/autocomplete/{term}', [CurricularComponentCategoryController::class, 'autocomplete'])->name('autocompletar');
        });

        /**NIVEL ENSINO**/
        Route::group(['prefix' => 'niveis-ensino', 'as' => 'niveis.'], function () {
            Route::get('/search/{termo}', [NivelEnsinoController::class, 'search'])->name('buscar');
            Route::get('/', [NivelEnsinoController::class, 'index'])->name('listar');
            Route::get('/{id}', [NivelEnsinoController::class, 'getById'])->name('x.id');
            Route::post('/', [NivelEnsinoController::class, 'create'])->name('criar');
            Route::put('/{id}', [NivelEnsinoController::class, 'update'])->name('atualizar');
            Route::get('/autocomplete/{term}', [NivelEnsinoController::class, 'autocomplete'])->name('autocompletar');
            Route::delete('/{id}', [NivelEnsinoController::class, 'delete'])->name('deletar');
        });

        /** AUTENTICACAO */
        Route::group(['prefix' => 'auth', 'as' => 'usuario.'], function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('sair');
            Route::post('/refresh', [AuthController::class, 'refresh'])->name('refrescar.token');
            Route::get('/links-admin', [AuthController::class, 'linksAdmin'])->name('links.admin');
        });

        /** TIPOS */
        Route::group(['prefix' => 'tipos', 'as' => 'tipos.'], function () {
            Route::post('/', [TipoController::class, 'create'])->name('criar');
            Route::put('/{id}', [TipoController::class, 'update'])->name('atualizar');
            Route::delete('/{id}', [TipoController::class, 'delete'])->name('deletar');
        });

        /** ROLES */
        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('listar');
            Route::get('/{id}', [RoleController::class, 'getById'])->name('x.id');
            Route::post('/', [RoleController::class, 'create'])->name('criar');
            Route::put('/{id}', [RoleController::class, 'update'])->name('atualizar');
            Route::delete('/{id}', [RoleController::class, 'delete'])->name('deletar');
            Route::get('/search/{term}', [RoleController::class, 'search'])->name('busca');
        });

        /** USUARIOS */
        Route::group(['prefix' => 'usuarios', 'as' => 'usuarios.'], function () {
            Route::get('/search/{termo}', [UserController::class, 'search'])->name('buscar');
            Route::delete('/{id}', [UserController::class, 'delete'])->name('deletar');
            Route::get('/{id}', [UserController::class, 'getById'])->name('x.id');
            Route::get('/', [UserController::class, 'index'])->name('listar');
            Route::put('/{id}', [UserController::class, 'update'])->name('atualizar');
            Route::put('/reset-password', [UserController::class, 'resetPass'])->name('senha.atualizar');
            Route::post('/', [UserController::class, 'create'])->name('adicionar');
        });

        /** APLICATIVOS */
        Route::group(['prefix' => 'aplicativos', 'as' => 'aplicativos.'], function () {
            Route::post('/', [AplicativoController::class, 'create'])->name('adicionar');
            Route::put('/{id}', [AplicativoController::class, 'update'])->name('editar');
            Route::delete('/{id}', [AplicativoController::class, 'delete'])->name('apagar');
            /* APLICATIVOS CATEGORIAS */
            Route::post('/categories', [AplicativoCategoryController::class, 'create'])->name('criar.categorias');
            Route::put('/categories/{id}', [AplicativoCategoryController::class, 'update'])->name('atualizar.categorias');
            Route::delete('/categories/{id}', [AplicativoCategoryController::class, 'delete'])->name('apagar.categorias');
        });

        /** TAGS */
        Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
            Route::get('/', [TagController::class, 'index'])->name('listar');
            Route::post('/', [TagController::class, 'create'])->name('adicionar');
            Route::get('/search/{term}', [TagController::class, 'search'])->name('search');
            Route::get('/autocomplete/{term}', [TagController::class, 'autocomplete'])->name('autocomplete');
            Route::put('/{id}', [TagController::class, 'update'])->name('atualizar');
            Route::delete('/{id}', [TagController::class, 'delete'])->name('deletar');
        });

        /** CONTEUDOS */
        Route::group(['prefix' => 'conteudos', 'as' => 'conteudos.'], function () {
            Route::post('/', [ConteudoController::class, 'create'])->name('adicionar');
            Route::put('/{id}', [ConteudoController::class, 'update'])->name('atualizar');
            Route::delete('/{id}', [ConteudoController::class, 'delete'])->name('apagar');
            Route::post('/arquivos', [ConteudoController::class, 'storeFiles'])->name('salvar.arquivo');
        });

        /** CANAIS */
        Route::group(['prefix' => 'canais', 'as' => 'canais.'], function () {
            Route::get('/', [CanalController::class, 'index'])->name('listar');
            Route::post('/', [CanalController::class, 'create'])->name('adicionar');
            Route::put('/{id}', [CanalController::class, 'update'])->name('atualizar');
            Route::delete('/{id}', [CanalController::class, 'delete'])->name('deletar');
            Route::get('/{id}', [CanalController::class, 'getById'])->name('x.id');
            Route::get('/search/{term}', [CanalController::class, 'search'])->name('buscar');
            //->middleware('can:update,canal');
        });

        /** LICENCAS */
        Route::group(['prefix' => 'licencas', 'as' => 'licencas.'], function () {
            Route::get('/search/{term}', [LicenseController::class, 'search'])->name('search');
            Route::get('/{id}', [LicenseController::class, 'getById'])->name('x.id');
            Route::post('/', [LicenseController::class, 'create'])->name('adicionar');
            Route::put('/{id}', [LicenseController::class, 'update'])->name('atualizar');
            Route::delete('/{id}', [LicenseController::class, 'delete'])->name('deletar');
        });

        /** DENUNCIAS */
        Route::group(['prefix' => 'contato', 'as' => 'contato.'], function () {
            Route::get('/', [ContatoController::class, 'index'])->name('listar.contatos');
            Route::get('/{id}', [ContatoController::class, 'getById'])->name('x.id');
            Route::delete('/{id}', [ContatoController::class, 'delete'])->name('deletar');
        });
        /** OPTIONS */
        Route::group(['prefix' => 'options', 'as' => 'options.'], function () {
            Route::post('/', [OptionsController::class, 'create'])->name('criar');
            Route::put('/{name}', [OptionsController::class, 'update'])->name('atualizar.x.nome');
            Route::delete('/{name}', [OptionsController::class, 'delete'])->name('apagar.x.nome');
            Route::post('/destaques/create', [OptionsController::class, 'createDestaques'])->name('adicionar');
            Route::get('/id/{id}', [OptionsController::class, 'getById'])->name('x.id');
        });
        /** ANALYTICS */
        Route::get('/resumo', [HomeController::class, 'getAnalytics'])->name('catalogacao.blog.e.plataforma');
        Route::get('/dashboard', [DashboardController::class, 'getCards'])->name('cards.dashboard');
        Route::get('/dashboard/{id}', [DashboardController::class, 'getById'])->name('data.x.id');
        Route::get('/dashboard/filtros/{id}', [DashboardController::class, 'getFiltros'])->name('filtros');
        Route::get('/dashboard/filtros/mes/{id}', [DashboardController::class, 'getFiltrosMes'])->name('filtrosMes');
        Route::get('dashboard/filtros/aplicativos/{id}', [DashboardController::class, 'getFiltrosAplicativos'])->name('filtrosAplicativos');
        Route::get('dashboard/filtros/canal/{id}', [DashboardController::class, 'getFiltroscatalogacaoPorCanal'])->name('filtrosCatalogacaoPorCanal');

        /** RELATÓRIOS */
        Route::group(['prefix' => 'relatorio', 'as' => 'relatorio.'], function () {
            Route::get('/usuarios/role/{role_id}', [RelatorioController::class, 'buscarUsuariosPorRole'])->name('view.relatorio.usuario');
            Route::get('/conteudos/{flag}', [RelatorioController::class, 'gerarPdfConteudo'])->name('gerar.relatorio.conteudo');
            Route::get('/usuarios/role/{role_id}/{is_active?}', [RelatorioController::class, 'gerarPdfUsuario'])->name('gerar.relatorio.usuario');
            Route::get('/anospublicacao', [RelatorioController::class, 'anosComConteudosPublicados'])->name('anospublicacao.relatorio');
            Route::get('/conteudosporoano/{ano}', [RelatorioController::class, 'conteudosPublicadosPorAno'])->name('conteudosporano.relatorio');
        });
        /** SISTEMA DE PASTA */
        Route::get('/informacoes-pasta', [FileController::class, 'getInfoFolder'])->name('file.getInfoFolder');
        Route::get('/arquivos-existe', [FileController::class, 'fileExistInBase'])->name('file.fileExistInBase');
        Route::post('/converter-para-imagem', [FileController::class, 'convertPdfToImage'])->name('file.convertPdfToImage');
        Route::delete('/files', [FileController::class, 'deleteFile'])->name('file.delete');
        /** COMENTARIOS */
        Route::group(['prefix' => 'comentarios', 'as' => 'comentarios.'], function () {
            Route::post('/create', [ComentarioController::class, 'create'])->name('criar');
            Route::put('/{id}', [ComentarioController::class, 'update'])->name('atualizar');
            Route::get('/{id}', [ComentarioController::class, 'getComentarioById'])->name('x.id');
            Route::get('/usuario/{idUsuario}/{tipo?}', [ComentarioController::class, 'getComentariosByIdUsuario'])->name('x.id.usuario');
            Route::get('/postagem/{id}/{tipo}', [ComentarioController::class, 'getComentariosByIdPostagem'])->name('postagem');
            Route::get('/delete/{id}', [ComentarioController::class, 'deletar'])->name('deletar');
        });
        /** LIKE - DESLIKE */
        Route::post('/like', [ConteudoLikeController::class, 'like'])->name('like');
        Route::post('/dislike', [ConteudoLikeController::class, 'dislike'])->name('dislike');
        Route::get('/likes/usuario/{idUsuario}/{tipo?}', [ConteudoLikeController::class, 'getLikesPorIdUsuarioEtipo'])->name('likes.usuario');
        Route::get('/likes/conteudo/{conteudoid}/{tipo}', [ConteudoLikeController::class, 'getUsuarioLikesConteudoAplicativo'])->name('likes.usuario.conteudo.aplicativo');
    }
);
