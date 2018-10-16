<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
  public $loginAfterSignUp = true;
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
       
      $input = $request->only('email', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Email ou Senha inválidos',
            ], 401);
        }
        $currentUser = JWTAuth::user();

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'user' => $currentUser
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPass(Request $request)
    {
        
        
    }
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
            dd($request->token);
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'Usuário desconectado'
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Desculpe, erro ao desconectar'
            ], 500);
        }
    }
    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }
    public function delete(Request $request)
    {
      
    }
    public function list(Request $request)
    {
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
