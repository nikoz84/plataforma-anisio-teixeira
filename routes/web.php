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

Route::get('/email', function (Request $request) {
    return new App\Mail\SendMail($request);
});
Route::get('/teste', function (Request $request) {
    $wordpres_auth = new App\Helpers\WordpressService();
    return $wordpres_auth->authorization($request->code);
});
Route::get('/{any}', 'SpaController@index')->where('any', '.*');
