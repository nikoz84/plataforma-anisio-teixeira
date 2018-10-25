<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware('jwt.verify');
    }
    public function list(Request $request)
    {
      $limit = ($request->has('limit')) ? $request->query('limit') : 20;        
      $page = ($request->has('page')) ? $request->query('page') : 1;
         

      $paginator = User::where("options->is_active",'true')
                    ->paginate($limit);
      
      return response()->json([
        'title'=> 'Lista de usuários',
        'items'=>$paginator,
        'page'=> $paginator->currentPage(),
        'limit' => $paginator->perPage()
      ]);
    }
    public function getById(Request $request, $id)
    {

    }
    public function delete(Request $request, $id)
    {
      
    }
}
