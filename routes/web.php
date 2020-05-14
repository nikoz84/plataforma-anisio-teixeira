<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/docs', function (Request $request) {
    return view('docs');
});

*/



Route::get('/conteudos-digitais/conteudo/incorporar-conteudo/id/{id}', 'ConteudoController@incorporarConteudo');

Route::get(
    'teste',
    function () {
        $user = Auth::user();
        dd($user);
        $sidebar = new App\Helpers\SideBar;
        $sidebar->getAdminSidebar($user);
    }
);

Route::get('/{any}', 'ApiController@home')->where('any', '.*');


