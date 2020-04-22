<?php

use Illuminate\Support\Facades\DB;
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
Route::get('/restart-senha', function (\Illuminate\Http\Request $request) {
    
    $paginator = DB::table('users')->orderBy('id')->paginate($request->limit);
    $paginator->currentPage($request->page);
    $users = collect($paginator);
    
    foreach ($users['data'] as $user) {
        DB::table('users')
        ->where('id', $user->id)
        ->update(
            [
                'password' => bcrypt('mudat@2020'),
                'verified' => false
            ]
        );
    }
    echo "OK {$request->page}";
});
Route::get('/teste', function (\Illuminate\Http\Request $request) {

    
        $user = App\User::find(2675);
        
        $token = Illuminate\Support\Str::random(40);
        return new App\Mail\SendVerificationEmail($user, $token);
    //if (Crawler::isCrawler()) {}
});

Route::get('/{any}', 'ApiController@home')->where('any', '.*');
