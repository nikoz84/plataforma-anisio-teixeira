<?php

namespace App\Http\Controllers;

use App\Helpers\SideBar;
use App\Http\Controllers\ApiController;
use App\User;
use App\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationEmail;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except([
            'login', 'register', 'verifyEmail', 'recoverPass',
            'verifyToken', 'verifyTokenUserRegister', 'linksAdmin'
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

        
        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse([], 'E-mail ou Senha inválidos', 422);
        }
       
        return $this->respondWithToken($token);
    }
    /**
     * Usuário logado
     *
     * @return App\Traits\ApiResponser
     */
    public function linksAdmin()
    {
        $user = auth('api')->user();
        
        $sidebar = new SideBar;

        return $this->successResponse([
            
            'links' => $sidebar->getAdminSidebar($user)
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
        $token = auth('api')->refresh();

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
        $validator = Validator::make(
            $request->all(),
            $this->rulesRegister()
        );

        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                "Verifique os dados fornecidos",
                422
            );
        }

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

            return $this->errorResponse([], "Erro ao enviar Email", 422);
        }

         return $this->errorResponse([], "Erro ao cadastrar Usuário", 422);
    }
    /**
     * Recuperar senha
     *
     */
    public function recoverPass(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'recaptcha' => ['required', new \App\Rules\ValidRecaptcha]
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                "Verifique os dados fornecidos",
                422
            );
        }
        
        $usuario = User::where('email', $request->email)->first();

        if (!$usuario) {
            return $this->errorResponse([], 'Usuário não encontrado!', 422);
        }

        PasswordReset::create([
            'email' => $usuario->email,
            'token' => $usuario->createVerificationToken(),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // Recupera o token gerado direto da tabela
        $tokenGerado = new PasswordReset();
        $token = $tokenGerado->getTokenByEmail($usuario->email)->token;
        
        // Dispara o Email
        if ($this->sendConfirmationEmail($usuario->email, $token, 'recoverPass')) {
            return $this->successResponse([], 'Email enviado com Sucesso!', 200);
        }

        return $this->errorResponse([], 'Erro ao enviar Email!', 422);
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
        $passwordReset = new PasswordReset();
        $user = new User();

        return $user->verifyToken($token, $passwordReset);
    }

    public function verifyTokenUserRegister(Request $request, $token)
    {
        $user = new User();
        return $user->verifyTokenUserRegister($token);
    }
}
