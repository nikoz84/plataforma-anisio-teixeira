<?php

namespace App\Http\Controllers;

use App\Helpers\SideBar;
use App\Http\Controllers\ApiController;
use App\User;
use App\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationEmail;
use Exception;

class AuthController extends ApiController
{
    public function __construct(Request $request)
    {
        $this->middleware('jwt.verify')->except([
            'login', 'register', 'verifyEmail', 'recoverPass', 'verifyToken', 'verifyTokenUserRegister'
        ]);

        $this->request = $request;
    }
    /**
     * Login Usuario.
     *
     * @return App\Http\Controllers\AuthController\resp
     */
    public function login()
    {
        $validator = Validator::make(
            $this->request->all(),
            [
                'email' => 'required|string|max:60|email',
                'password' => 'required|min:6',
                'recaptcha' => ['required', new \App\Rules\ValidRecaptcha]
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Usuário ou senha inválidos", 422);
        }

        $credentials = $this->request->only('email', 'password');

        $token = null;

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse([], 'E-mail ou Senha inválidos', 422);
            }
        } catch (JWTException $e) {
            return $this->errorResponse([], 'Impossível criar Token de acesso', 422);
        }
        
        return $this->respondWithToken($token);
    }
    /**
     * Usuário logado
     *
     * @return App\Traits\ApiResponser
     */
    public function getAuthUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return $this->errorResponse([], 'Usuário não encontrado', 404);
            }
        } catch (TokenExpiredException $e) {
            return $this->errorResponse([], 'Token Expirado', 401);
        } catch (TokenInvalidException $e) {
            return $this->errorResponse([], 'Token Inválido', 403);
        } catch (JWTException $e) {
            return $this->errorResponse([], 'Token Ausente', 403);
        }

        $sidebar = new SideBar;

        return $this->successResponse([
            'user_data' => compact('user'),
            'links' => $sidebar->getAdminSidebar(JWTAuth::user())
        ]);
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
        $token = auth()->refresh();

        return $this->respondWithToken($token, "Token renovado");
    }

    /**
     * Get the token array structure.
     *
     * @param $token token gerado pelo JWTAuth
     * @param $message menssagem retornado para o usuário
     *
     * @return App\Traits\ApiResponser
     */
    protected function respondWithToken($token, $message = '')
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];

        return $this->successResponse($data, $message) ;
    }
    /**
     * Registro do usuário.
     *
     * @return App\Traits\ApiResponser
     */
    public function register(Request $request)
    {
        /*$validator = Validator::make(
            $request->all(),
            $this->rulesRegister()
        );

        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                "Verifique os dados fornecidos",
                422
            );
        }*/

        $user = new User;
        $token = $user->createVerificationToken();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->verified = User::USER_NOT_VERIFIED;
        $user->verification_token = $token;
        $user->options = [
            "sexo" => null,
            "birthday" => null,
            "telefone" => null,
            "is_active" => false,
            "neighborhood"=> null
        ];

        if ($user->save()) {
            if ($this->sendConfirmationEmail($user->email, $token, 'register')) {
                return $this->successResponse([], "Espere a confirmação na sua conta de email", 200);
            }

            return $this->errorResponse([], "Erro ao enviar Email", 500); 
        }

         return $this->errorResponse([], "Erro ao cadastrar Usuário", 500); 
    }
    /**
     * Recuperar senha
     *
     */
    public function recoverPass(Request $request)
    {
        $usuario = User::where('email', $request->email)->first();

        if (is_null($usuario)) {
            return $this->errorResponse([], 'Usuário não encontrado!');

        } else {
            $reset = PasswordReset::create([
                'email' => $usuario->email, 
                'token' => $usuario->createVerificationToken(),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            // Recupera o teken gerado direto da tabela
            $tokenGerado = new PasswordReset();
            $token = $tokenGerado->getTokenByEmail($usuario->email)->token;
            
            // Dispara o Email
            if ($this->sendConfirmationEmail($usuario->email, $token, 'recoverPass')) {
                return $this->successResponse([], 'Email enviado com Sucesso!', 200);
            }

            return $this->errorResponse([], 'Erro ao enviar Email!', 500);
        }
    }
    /**
     * Regras de validação
     *
     * @return array
     */
    public function rulesRegister()
    {
        return [
            'name' => 'required|string|max:255|min:4',
            'email' => 'required|email|string|max:100|unique:users',
            'password' => 'required|string|min:6|required_with:confirmation|same:confirmation',
            'confirmation' => 'required',
            'recaptcha' => ['required', new \App\Rules\ValidRecaptcha]
        ];
    }
    /**
     * Envia email de verificação
     *
     * @param $email string
     *
     * @return App\Traits\ApiResponser
     */
    protected function sendConfirmationEmail($email, $token, $option)
    {
        $user = User::where('email', 'ilike', "%{$email}%")->first();
        
        try {
            Mail::send(new SendVerificationEmail($user, $token, $option));
        
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    /**
     * Verificar email
     *
     * @param $request \Illuminate\Http\Request
     * @param $token   token de validação
     *
     * @return \App\Traits\ApiResponser
     */
    public function verifyToken(Request $request, $token)
    {
        // Recupera o teken gerado direto da tabela
        $passwordReset = new PasswordReset();
        $tokenGerado = $passwordReset->getToken($token);

        // Verifica se o token da rota é o mesmo que foi gerado para o usuário
        if ( ! is_null($tokenGerado) && $token == $tokenGerado->token) {
            
            // Verifica se o token ainda está valido
            if ($passwordReset->tokenValidation($token)) {
                return redirect('usuario/recuperar-senha');
            }

            return response()->json([
                'success' => false,
                'message' => 'Este token expirou e não é mais valido!'
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Token não encontrado!'
            ]);
        }
    }

    public function verifyTokenUserRegister(Request $request, $token)
    {
        $user = new User();
        return $user->verifyTokenUserRegister($token);
    }
}
