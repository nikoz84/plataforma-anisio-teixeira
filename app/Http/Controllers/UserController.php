<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPass(Request $request)
    {
        
        
    }

    public function list(Request $request){
      $limit = ($request->has('limit')) ? $request->query('limit') : 10;        
      $page = ($request->has('page')) ? $request->query('page') : 1;   

      $users = User::where("options->is_active",'true')
                    ->limit($limit)
                    ->offset($page)
                    ->get();

      return response()->json([
        'title'=> 'Lista de usuários',
        'items'=>$users
      ]);
    }
}
