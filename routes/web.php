<?php

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
use App\Aplicativo;


Route::get('/email', function (Request $request) {
    return new App\Mail\SendMail($request);
});



Route::get('/teste', function (Request $request) {
    $wordpres = new App\Helpers\WordpressService($request->limit, $request->page);

    return $wordpres->getPosts();
});

Route::get('/form', function (Request $request){
    if($request->all()){
        dd($request->all());
    }
    return view('forms.teste');
});

Route::get('/{any}', 'SpaController@index')->where('any', '.*');
