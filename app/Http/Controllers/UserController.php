<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Gate;
use App\Http\Controllers\ApiController;
use App\Traits\ApiResponser;

class UserController extends ApiController
{
    use ApiResponser;

    public function __construct(Request $request, User $user)
    {
        $this->middleware('jwt.verify')->except([]);
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * Lista de usuários
     *
     *
     */
    public function index()
    {

        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'name';
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;
        $query = $this->user::query();
        $paginator = $query->orderBy('name', 'asc')->paginate($limit);
        $paginator->setPath("/usuarios?limit={$limit}");
        return response()->json([
            'success' => true,
            'title' => 'Lista de Usuários',
            'paginator' => $paginator
        ]);
    }
    /**
     * Buscar usuário por ID
     *
     * @param [integer] $id
     * @return json
     */
    public function getById($id)
    {
        $user = $this->user::find($id)->makeVisible('email')->toArray();

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
    public function update($id)
    {
        $user = $this->user::find($id);

        if (Gate::denies('super-admin', $user)) {
            return $this->errorResponse([], 'Usuário sem permissão de acesso!', 403);
        }

        $user->fill($this->request->all());
        $user->save();
        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }
    /**
     * Método apagar por id
     *
     * @param [integer] $id
     * @return json
     */
    public function delete($id)
    {
        $resp = $this->user::where(['id' => $id])->delete();
        if (Gate::denies('super-admin', $resp)) {
            return $this->errorResponse([], 'Usuário sem permissão de acesso!', 403);
        }
        if (!$resp) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível deletar usuário',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Usuário deletado com sucesso!!',
        ]);
    }
    public function search(Request $request, $termo)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 20;
        $search = "%{$termo}%";
        $paginator = User::whereRaw('unaccent(lower(name)) ilike unaccent(lower(?))', [$search])
            ->paginate($limit);

        $paginator->setPath("/usuarios/search/{$termo}?limit={$limit}");

        return response()->json([
            'success' => true,
            'title' => 'Resultado da busca',
            'paginator' => $paginator,
        ]);
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
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível salvar usuário',
                'errors' => $validator->errors(),
            ], 200);
        }

        $user = $this->user;

        $user->email = $this->request->get('login');
        $user->name = $this->request->get('name');
        $user->password = bcrypt($this->request->get('password'));
        $user->options = json_decode($this->request->get('options', '{}'), true);

        $resp = $user->save();

        if ($resp) {
            return response()->json([
                'success' => true,
                'message' => 'Usuário registrado com sucesso',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não registrado',
            ]);
        }
    }

    public function verify($token)
    {
        $user = $this->user::where('verification_token', $token)->firstOrFail();
        $user->verified = $this->user::USER_NOT_VERIFIED;
        $user->verification_token = null;
        $user->save();
        return $this->showOne('Conta verificada', 200);
    }
}
