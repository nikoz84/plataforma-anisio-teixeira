<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{

    public function __construct(Request $request)
    {
        $this->middleware('jwt.verify')->except([]);
        $this->request = $request;
    }

    /**
     * Lista de usuários
     *
     *
     */
    public function index()
    {
        $this->authorize('index', JWTAuth::user());

        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'name';
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;
        $query = User::query();
        $paginator = $query->orderBy('name', 'asc')->paginate($limit);
        $paginator->setPath("/usuarios?limit={$limit}");

        return $this->showAsPaginator($paginator, '', 200);
    }
    /**
     * Buscar usuário por ID
     *
     * @param [integer] $id
     * @return json
     */
    public function getById($id)
    {
        $user = User::with('role')->findOrFail($id)->makeVisible('email');

        $this->authorize('index', [$user]);

        return $this->showOne($user, '', 200);
    }
    /**
     * Atualizar usuário por ID
     *
     * @param [integer] $id
     * @return json
     */
    public function update($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $user->fill($this->request->all());

        if (!$user->save()) {
            $this->errorResponse([], 'Não foi possível editar o usuário', 422);
        }

        return $this->successResponse($user, 'Usuário editado com sucesso!', 200);
    }
    /**
     * Método apagar por id
     *
     * @param [integer] $id
     * @return json
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);

        if (!$user->delete()) {
            return $this->errorResponse([], 'Não foi possível deletar o usuário', 422);
        }

        return $this->successResponse([], 'Usuário deletado com sucesso!!', 200);
    }
    public function search($termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 20;
        $search = "%{$termo}%";

        $paginator = User::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])
            ->paginate($limit);

        $paginator->setPath("/usuarios/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($paginator, '', 200);
    }
    /**
     * Valida a criação do Usuário
     *
     * @return
     */
    private function validar()
    {
        $validator = Validator::make($this->request->all(), [
            'email' => 'required|unique:email',
            'name' => 'required|min:2|max:255',
            'role' => 'required',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6|same:password',
            'birthday' => 'required|date|date_format:Y-m-d',
        ]);

        return $validator;
    }

    public function create()
    {
        $validator = $this->validar($this->request->all());
        if ($validator->fails()) {
            $this->errorResponse(
                $validator->errors(),
                'Não foi possível salvar usuário',
                422
            );
        }

        $user = $this->user;

        $user->email = $this->request->get('login');
        $user->name = $this->request->get('name');
        $user->password = bcrypt($this->request->get('password'));
        $user->options = json_decode($this->request->get('options', '{}'), true);


        if (!$user->save()) {
            $this->errorResponse([], 'não foi possível registrar o usuário', 422);
        }

        return $this->successResponse([], 'Usuário registrado com sucesso!', 200);
    }

    public function verify($token)
    {
        $user = USER::where('verification_token', $token)->firstOrFail();
        $user->verified = USER::USER_NOT_VERIFIED;
        $user->verification_token = null;
        $user->save();
        return $this->showOne($user, 'Conta verificada', 200);
    }
}
