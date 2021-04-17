<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\StorageUser;

class UserController extends ApiController
{
    protected $request;

    public function __construct(Request $request)
    {
        //$this->middleware('jwt.auth')->except([]);
        $this->request = $request;
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
     * @param $id integer
     * @return App\Traits\ApiReponser
     */
    public function getById($id)
    {
        $user = User::with('role')->findOrFail($id)->makeVisible('email');
        $this->authorize('index', [$user]);
        return $this->showOne($user, '', 200);
    }

    /**
     * Cria novo usuário
     * @param $request
     * @return App\Traits\ApiResponser
     */
    public function create(UserRequest $request)
    {
        $user = new User;
        $this->authorize('create', $user);

        $user->fill($request->validated());

        return $this->saveFile($user, $request);
        
    }
    /**
     * Atualizar usuário por ID
     *
     * @param $request \Illuminate\Http\Request
     * @param $id integer
     * @return App\Traits\ApiResponser
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $user->fill($request->validated());
        
        
        
        return $this->saveFile($user, $request);
    }

    public function saveFile(User $user, $request)
    {
        if (!$user->save()) {
            return $this->errorResponse([], 'Não foi possível editar o usuário', 422);
        }
        
        if ($request->has('arquivoImagem')) {
            $storage = new StorageUser();
            $user = $storage->saveFile($user, $request);
            if (!$user) {
                return $this->errorResponse([], 'Não foi possível fazer o upload da imagem', 422);
            }
        }
        
        
        return $this->successResponse($user, 'Usuário editado com sucesso!', 200);
    }

    /**
     * Método apagar por id
     * @param $id integer
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
     * @param $request \Illuminate\Http\Request
     * @param $termo string de busca
     * @return App\Traits\ApiResponser
     */
    public function search(Request $request, $termo)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 20;
        $search = "%{$termo}%";
        $paginator = User::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])->paginate($limit);
        $paginator->setPath("/usuarios/search/{$termo}?limit={$limit}");
        return $this->showAsPaginator($paginator, '', 200);
    }

    /**
     * Valida a criação do Usuário
     * @return array
     */
    protected function configRules()
    {
        return [
            'email' => 'required|unique:users,email',
            'name' => 'required|min:2|max:255',
            'role' => 'required',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6|same:password',
            'optionsbirthday' => 'required|date|date_format:Y-m-d',
        ];
    }
}