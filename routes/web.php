<?php

use App\Http\Controllers\ConteudoController;
use App\Http\Controllers\RedirectRoutesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IatDocsController;

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Web\HomeController;
//use App\Http\Controllers\Web\UserController;
//use App\Http\Controllers\Web\CanalController;

/*
Route::get('/email', function (Request $request) {
    return new App\Mail\SendMail($request);
});


Route::get('/docs', function (Request $request) {
    return view('docs');
});

*/

/** Iat Docs  */
Route::get('/iat-docs/{id}', [IatDocsController::class, 'iatDocs']);


/** Redireção de páginas antigas */
Route::permanentRedirect('/home/ipes', '/ipes');
Route::permanentRedirect('/home/rotinas-de-estudo', '/rotinas-de-estudo');
Route::permanentRedirect('/conteudos-digitais', '/recursos-educacionais');
Route::get('/conteudos-digitais/conteudos/listar/tag/{id}', [
    RedirectRoutesController::class, 'redirectTags',
]);
Route::get('/tv-anisio-teixeira/programas/exibir/id/{id}', [
    RedirectRoutesController::class, 'redirectTV',
]);
Route::get('/emitec/disciplinas/exibir/id/{id}', [
    RedirectRoutesController::class, 'redirectEmitec',
]);
Route::get('/emitec/disciplinas/aulas/id/{id}/disciplina/{disciplina}', [
    RedirectRoutesController::class, 'redirectAulasEmitec',
]);

Route::get('/conteudos-digitais/conteudo/exibir/id/{id}', [
    RedirectRoutesController::class, 'redirectRecursos',
]);
Route::get('/conteudos-digitais/conteudo/incorporar-conteudo/id/{id}', [
    RedirectRoutesController::class, 'redirectIncorporar',
]);
Route::get('/conteudos/conteudos-digitais/download/{id}', [
    RedirectRoutesController::class, 'redirectDownload',
]);

Route::get('/incorporar-conteudo/{id}', [ConteudoController::class, 'incorporarConteudo']);

//Route::get('/teste-ffmpeg/{id}', 'FileController@ffmpegTeste');

//Route::get('/streaming-video/{id}', 'FileController@showVideoStreaming');

//Route::get('/teste', [RedirectRoutesController::class, 'teste']);

Route::get('/{any}', [\App\Http\Controllers\ApiController::class, 'home'])
    ->where('any', '.*');