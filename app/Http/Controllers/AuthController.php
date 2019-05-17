<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify')->except(['login', 'register']);
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
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email ou Senha inválidos',
                ], 201);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Impossível criar Token de acesso',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'token' => $this->respondWithToken($token),
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
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não encontrado',
                    'status' => 'user_not_found'
                ], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token Expirado',
                'status' => 'token_expired'
            ], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token Inválido',
                'status' => 'token_invalid'
            ], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token Ausente',
                'status' => 'token_absent'
            ], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Usuário Deslogado com sucesso!!',
            'success' => true,
        ], 200);
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
            'token' => $this->respondWithToken(auth()->refresh()),
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
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
    /**
     * Registro do usuário.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), config('form.registro'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível completar o cadastro',
                'errors' => $validator->errors(),
            ], 201);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //$this->confirmationEmail();

        return response()->json([
            'success' => true,
            'message' => "Verifique seu email para confirmar o cadastro"
        ], 200);
    }
    private function confirmationEmail()
    {
        //
    }
}
