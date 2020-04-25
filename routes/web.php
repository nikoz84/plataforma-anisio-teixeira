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



Route::get('/teste', function (\Illuminate\Http\Request $request) {
    $conteudo = App\Conteudo::find(10409);
    $aplicativo = App\Aplicativo::find(31);
    
    return response()->json([ 'conteudo' => $conteudo, 'aplicativo' => $aplicativo ]);
    //if (Crawler::isCrawler()) {}
});

Route::get('/{any}', 'ApiController@home')->where('any', '.*');
