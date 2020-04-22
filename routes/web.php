<?php

use Illuminate\Support\Facades\Route;

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


/**/

Route::get('/teste', function (\Illuminate\Http\Request $request) {

    $query = App\Conteudo::query();
    $componentes = $request->componentes;

    $query->when($componentes, function ($q, $componentes) {

        return $q->searchByComponent($componentes);
    });

    dd($query->get());
    return response()->json($query);
    //if (Crawler::isCrawler()) {}
});

Route::get('/{any}', 'ApiController@home')->where('any', '.*');
