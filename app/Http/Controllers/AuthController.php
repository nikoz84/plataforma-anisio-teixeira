<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify')->except(['login','register']);
    }
    /**
     * Login Usuario.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        
        $credentials = $request->only('email', 'password');
        $token = null;
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email ou Senha inválidos',
                ]);
            }
        }catch (JWTException $e) {
            
            return response()->json([
                'success' => false,
                'error' => 'Impossível criar Token de acesso'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'token' => $this->respondWithToken($token)
        ]);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser() 
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json([
                        'success'=> false,
                        'message'=> 'Usuário não encontrado',
                        'status'=>'user_not_found'], 404);
            }

            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                    return response()->json([
                        'success'=> false,
                        'message'=> 'Token Expirado',
                        'status'=>'token_expired'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                    return response()->json([
                        'success'=> false,
                        'message'=> 'Token Inválido',
                        'status'=>'token_invalid'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                    return response()->json([
                        'success'=> false,
                        'message'=> 'Token Ausente',
                        'status'=>'token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json([
            'message' => 'Usuário Deslogado com sucesso!!',
            'success' => true
        ]);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json([
            'success' => true,
            'token' => $this->respondWithToken(auth()->refresh())
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
    /**
     * Registro do usuário.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = auth()->login($user);

        return response()->json([
            'success'=> true,
            $this->respondWithToken($token)
        ]);
        
    }
    
}