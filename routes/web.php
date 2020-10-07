<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/email', function (Request $request) {
    return new App\Mail\SendMail($request);
});



Route::get('/teste', function (Request $request) {
    //$wordpres = new App\Helpers\WordpressService($request->limit, $request->page);
    $colaborativus = new App\Helpers\ColaborativusService();

    return $colaborativus->findCourses();
    //return $wordpres->getPosts();
});

Route::get('/docs', function (Request $request) {
    return view('docs');
});

*/

/** Redireção de páginas antigas */
Route::permanentRedirect('/home/ipes', '/ipes');
Route::permanentRedirect('/home/rotinas-de-estudo', '/rotinas-de-estudo');
Route::permanentRedirect('/conteudos-digitais', '/recursos-educacionais');
Route::get('/conteudos-digitais/conteudos/listar/tag/{id}', function ($id) {
    return redirect("/recursos-educacionais/listar?tag={$id}");
});
Route::get('/tv-anisio-teixeira/programas/exibir/id/{id}', function ($id) {
    return redirect("/tv-anisio-teixeira/conteudo/exibir/{$id}");
});
Route::get('/emitec/disciplinas/exibir/id/{id}', function ($id) {
    return redirect("/emitec/conteudo/exibir/{$id}");
});
Route::get('/emitec/disciplinas/aulas/id/{id}/disciplina/{disciplina}', function ($id, $disciplina) {
    return redirect("/emitec/listar?canal=2&componentes=$disciplina&categoria=$id");
});

Route::get('/conteudos-digitais/conteudo/exibir/id/{id}', function ($id) {
    return redirect("/recursos-educacionais/conteudo/exibir/{$id}");
});
Route::get('/conteudos-digitais/conteudo/incorporar-conteudo/id/{id}', function ($id) {
    return redirect("/incorporar-conteudo/{$id}");
});
Route::get('/conteudos/conteudos-digitais/download/{id}', function ($id) {
    //
});

Route::get('/incorporar-conteudo/{id}', 'ConteudoController@incorporarConteudo');

//Route::get('/teste-ffmpeg/{id}', 'FileController@ffmpegTeste');

//Route::get('/streaming-video', 'FileController@showVideoStreaming');

Route::get('/{any}', 'ApiController@home')->where('any', '.*');
