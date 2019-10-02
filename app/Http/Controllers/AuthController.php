<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\FormValidation;

class AuthController extends ApiController
{
    public function __construct(Request $request)
    {
        $this->middleware('jwt.verify')->except(['login', 'register']);
        $this->request = $request;
    }
    /**
     * Login Usuario.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $validator = Validator::make($this->request->all(), config("rules.login"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Usuário ou senha inválidos", 201);
        }

        $credentials = $this->request->only('email', 'password');

        $token = null;

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse([], 'E-mail ou Senha inválidos', 201);
            }
        } catch (JWTException $e) {
            return $this->errorResponse([], 'Impossível criar Token de acesso', 201);
        }
        $data = ['token' => $this->respondWithToken($token)];

        return $this->successResponse($data, "Bem vindo ", 200);
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
                return $this->errorResponse([], 'Usuário não encontrado', 201);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse([], 'Token Expirado', 201);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse([], 'Token Inválido', 201);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->errorResponse([], 'Token Ausente', 201);
        }

        return $this->successResponse(['user' => compact('user')], '', 200);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        auth()->logout();

        return $this->successResponse([], 'Volte pronto', 200);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $data = ['token' => $this->respondWithToken(auth()->refresh())];

        return $this->successResponse($data, "Token renovado", 200);
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
    public function register()
    {
        $validator = Validator::make($this->request->all(), config("rules.register"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Verifique os dados fornecidos", 201);
        }


        $user = new User;
        $user->name = $this->request->name;
        $user->email = $this->request->email;
        $user->password = bcrypt($this->request->password);
        $user->verified = User::USER_NOT_VERIFIED;
        $user->verification_token = User::createVerificationToken();

        $user->save();

        //$this->sendConfirmationEmail();

        return $this->successResponse([], "Espere a confirmação na sua conta de email", 200);
    }
    private function sendConfirmationEmail()
    {
        //
    }
}
