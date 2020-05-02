<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

Route::get('/form', function (Request $request) {
    if ($request->all()) {
        dd($request->all());
    }
    return view('forms.teste');
});

Route::get('/docs', function (Request $request) {
    return view('docs');
});

*/

Route::get('/conteudos-digitais/conteudo/incorporar-conteudo/{id}', 'ConteudoController@incorporarConteudo');

Route::get('/teste', function (\Illuminate\Http\Request $request) {
    $conteudo = App\Conteudo::find(9983);
    //$aplicativo = App\Aplicativo::find(31);
    
    return response()->json([ 'conteudo' => $conteudo ]);
    //if (Crawler::isCrawler()) {}
});

Route::get('/item-created', function () {
    $user = \App\User::find(54);
    $conteudo = new \App\Conteudo;
    
    $conteudo->user_id = $user->id;
    $conteudo->approving_user_id = $user;
    $conteudo->is_approved = true;
    $conteudo->tipo_id = 5;
    $conteudo->license_id = 3;
    $conteudo->canal_id = 6;
    $conteudo->category_id = null;
    $conteudo->title = 'teste 1522ss';
    $conteudo->description = 'Descriçao do conteudo digital asdasd';
    $conteudo->authors = 'UFBA';
    $conteudo->source = 'UFBA';
    $conteudo->options = ['site' => 'http://ufba.com'];
    $conteudo->is_featured = false;
    $conteudo->is_site = false;
    $conteudo->qt_downloads = \App\Conteudo::INIT_COUNT;
    $conteudo->qt_access = \App\Conteudo::INIT_COUNT;
    
    $conteudo->save();
    
    $conteudo->tags()->attach([11598,6617,744]);
    $conteudo->componentes()->attach([57,4,10]);
    $conteudo::tsDocumentoSave($conteudo->id);

    dd('Item created successfully.');

});



Route::get('/item-updated', function () {

    \App\Conteudo::find(1)->update(['name'=>'test 3', 'price'=>100]);

    dd('Item updated successfully.');

});

Route::get('/{any}', 'ApiController@home')->where('any', '.*');


