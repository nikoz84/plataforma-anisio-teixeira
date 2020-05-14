<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('jwt.auth')->except([]);
    }

    /**
     * Lista de usuários
     *
     * @param $request \Illuminate\Http\Request
     *
     * @return App\Traits\ApiResponser
     */
    public function index(Request $request)
    {
        $this->authorize('index', JWTAuth::user());

        $limit = $request->query('limit', 15);
        //$orderBy = ($request->has('order')) ? $request->query('order') : 'name';
        
        $query = User::query();
        $paginator = $query->orderBy('name', 'asc')->paginate($limit);
        $paginator->setPath("/usuarios?limit={$limit}");

        return $this->showAsPaginator($paginator, '', 200);
    }
    /**
     * Buscar usuário por ID
     *
     * @param $id integer
     *
     * @return App\Traits\ApiReponser
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
     * @param $request \Illuminate\Http\Request
     * @param $id integer
     *
     * @return App\Traits\ApiResponser
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $user->fill($request->all());

        if (!$user->save()) {
            $this->errorResponse([], 'Não foi possível editar o usuário', 422);
        }

        return $this->successResponse($user, 'Usuário editado com sucesso!', 200);
    }
    /**
     * Método apagar por id
     *
     * @param $id integer
     *
     * @return \App\Traits\ApiResponser
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
    /**
     * Procura usuario pelo nome
     *
     * @param $request \Illuminate\Http\Request
     * @param $termo string de busca
     *
     * @return App\Traits\ApiResponser
     */
    public function search(Request $request, $termo)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 20;
        $search = "%{$termo}%";

        $paginator = User::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])
            ->paginate($limit);

        $paginator->setPath("/usuarios/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($paginator, '', 200);
    }
    /**
     * Valida a criação do Usuário
     *
     * @return array
     */
    protected function configRules()
    {
        return [
            'email' => 'required|unique:email',
            'name' => 'required|min:2|max:255',
            'role' => 'required',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6|same:password',
            'optionsbirthday' => 'required|date|date_format:Y-m-d',
        ];
    }
    /**
     * Cria novo usuário
     *
     * @param $request
     *
     * @return App\Traits\ApiResponser
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        $validator = Validator::make(
            $request->all(),
            $this->configRules()
        );

        if ($validator->fails()) {
            $this->errorResponse(
                $validator->errors(),
                'Não foi possível salvar usuário',
                422
            );
        }

        $user = new User;

        $user->email = $request->get('login');
        $user->name = $request->get('name');
        $user->password = $request->get('password');
        $user->options = [
            "sexo" => null,
            "birthday" => null,
            "telefone" => null,
            "is_active" => false,
            "neighborhood"=> null
        ];


        if (!$user->save()) {
            $this->errorResponse([], 'não foi possível registrar o usuário', 422);
        }

        return $this->successResponse([], 'Usuário registrado com sucesso!', 200);
    }

    
}
