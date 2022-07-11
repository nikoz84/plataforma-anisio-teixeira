<?php

namespace App\Http\Controllers;

use App\Services\SideBar;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationEmail;
use Exception;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends ApiController
/**
 * Criacao e atualizacao de login e logout usando email
 * @param $int $id cadastro verificacao de login e senha
 * @param \Http\Controllers\AuthController
 */
{
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except([
            'login', 'register', 'verifyEmail', 'recoverPass',
            'verifyToken', 'verifyTokenUserRegister', 'linksAdmin', 'modificarSenha'
        ]);

        $this->request = $request;
    }

    /**
     * Login Usuario.
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
        //dd(JWTAuth::attempt($credentials));

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
     * Logout ou sair do sistema (Invalidate the token).
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
     * @param $token token gerado pelo JWTAuth
     * @param $message menssagem retornado para o usuário
     * @return App\Traits\ApiResponser
     */
    protected function respondWithToken($token, $message = '')
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];

        return $this->successResponse($data, $message);
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
        try {
            $user = new User;
            $token = $user->createVerificationToken();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->setPasswordAttribute($request->password);
            $user->verified = User::USER_NOT_VERIFIED;
            $user->verification_token = $token;
            $user->options = [
                "sexo" => null,
                "birthday" => null,
                "telefone" => null,
                "is_active" => false,
                "neighborhood" => null
            ];

            if (!$user->save()) {
                throw new Exception("Erro ao enviar os cadastrar usuário");
            }
            if (!$this->sendConfirmationEmail($user->email, $token, 'register')) {
                throw new Exception("Erro ao enviar email");
            }
        } catch (Exception $ex) {
            return $this->errorResponse([], $ex->getMessage(), 422);
        }

        return $this->successResponse(
            [],
            "Usuário cadastrado com sucesso! Espere o código de ativação em sua conta de email",
            200
        );
    }
    /** 
     * Recuperar senha do usuário
     * @return json response
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
        $data = [];
        // Dispara o Email
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception("Verifique os dados fornecidos");
            }

            $usuario = User::where('email', $request->email)->get()->first();
            if (!$usuario) {
                throw new Exception("Usuário não existe.");
            }
            PasswordReset::create([
                'email' => $usuario->email,
                'token' => $usuario->createVerificationToken(),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            // Recupera o token gerado direto da tabela
            $tokenGerado = new PasswordReset();
            $token = $tokenGerado->getTokenByEmail($usuario->email)->token;
            $email = $this->sendConfirmationEmail($usuario->email, $token, 'recoverPass');
            if (!$email) {
                throw new Exception("Erro ao enviar email.");
            }
        } catch (Exception $ex) {
            return $this->errorResponse($data, $ex->getMessage(), 422);
        }
        return $this->successResponse([], 'Email enviado com Sucesso!', 200);
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
     * @param $email string
     * @return App\Traits\ApiResponser
     */
    protected function sendConfirmationEmail($email, $token, $option)
    {
        $user = User::where('email', $email)->get()->first();

        try {
            Mail::send(new SendVerificationEmail($user, $token, $option));
            return true;
        } catch (Exception $ex) {
            Log::notice($ex->getMessage());
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
        try {
            $user->verifyToken($token, $passwordReset);
        } catch (Exception $ex) {
            Log::notice($ex->getMessage());
            return $this->errorResponse([], $ex->getMessage(), 404);
        }
        return $this->successResponse(null, "Token válido", 200);
    }

    /**
     * Verifica o token do usuário e registra
     * 
     * @param $request \Illuminate\Http\Request
     * @param $token  token de validação
     * 
     * @return \App\Models\User\verifyTokenUserRegister
     */
    public function verifyTokenUserRegister(Request $request, $token)
    {
        $user = new User();
        return $user->verifyTokenUserRegister($token);
    }

    /**
     * Modifica senha de usuario
     * @param string $token token gerado pela aplicação e enviado posteriormente
     * pelo usuário para comprovação de autorização
     * @return string
     */
    public function modificarSenha(string $token)
    {
        $passwordReset = new PasswordReset();
        $user = new User();
        $data = [];
        $validator = Validator::make(
            $this->request->all(),
            [
                'password' => 'required|min:8',
                'confirmation' => 'required|min:8'
            ]
        );
        try {
            $user->verifyToken($token, $passwordReset);
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception("Erro ao submeter formulário.");
            }
            if ($this->request->senha != $this->request->confirmacao) {
                throw new Exception("Senha e confirmação são imcompaiveis.");
            }
            $user = $this->getUserByToken($token);
            $user->setPasswordAttribute($this->request->password);

            if (!$user->save()) {
                throw new Exception("Erro ao tentar salvar modificação. Tente novamente mais tarde.");
            }
        } catch (Exception $ex) {
            return $this->errorResponse($data, $ex->getMessage(), 422);
        }
        return $this->successResponse($data, "Senha Modificada com sucesso!", 200);
    }

    private function getUserByToken($token)
    {
        $resetPass = new PasswordReset();
        $token = $resetPass->getToken($token);
        $user = User::where("email", $token->email)->first();
        return $user;
    }
}
