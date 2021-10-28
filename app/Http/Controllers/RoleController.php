<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use Gate;

class RoleController extends ApiController
{
    private $role;

    public function __construct(Request $request, Role $role)
    {
        $this->middleware('jwt.auth')->except([
            'index', 'search', 'getById',
        ]);
        $this->role = $role;
        $this->request = $request;
    }
    /**
     * Lista as informações do Banco de Dados.
     * @param string $name
     * @param \App\Role $role
     * @return \App\Controller\ApiResponser retorna Json
     */
    public function index()
    {
        if ($this->request->has('select')) {
            $select = $this->role::all();
            return $this->successResponse($select, '', 200);
        }
        $roles = $this->role::paginate();
        return $this->showAsPaginator($roles, '', 200);
    }
    /**
     * Cria informações no Banco de Dados
     *
     * @param string $name
     * @param \App\Role $role
     * @return \App\Controller\ApiResponser retorna Json
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), ["name" => "required"], $this->rulesMessages());
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o perfil", 422);
        }
        $role = $this->role;
        $role->name = $this->request->name;
        if ($role->save()) {
            return $this->successResponse($role, 'Perfil criado com sucesso!', 200);
        }
        return $this->errorResponse($validator->errors(), "Não foi possível criar o perfil", 501);
    }
    /**
     * Atualiza as informações do aplicativo no Banco de Dados.
     *
     * @param int $id identificador único
     * @param  \App\Role $role
     * @return  \App\Controller\ApiResponser retorna Json
     */
    public function update(Request $request, $id)
    {
        $role = $this->role::find($id);
        $this->authorize('delete', $role);
        $validator = Validator::make($this->request->all(), ["name" => "required"]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o perfil", 422);
        }
        $role = $this->role;
        $role->name = $this->request->name;
        if (!$role->save()) {
            return $this->errorResponse(
                $validator->errors(),
                "Não foi possível criar o perfil",
                422
            );
        }
        return $this->successResponse($role, 'Perfil editado com sucesso!', 200);
    }
    /**
     * Deleta o aplicativo no banco de dados
     * @param int $id identificador único
     * @param  \App\RoleController $role
     * @return \App\Controller\ApiResponser
     * retorna Json
     */
    public function delete($id)
    {

        $role = $this->role::find($id);

        $this->authorize('delete', $role);

        if ($role->delete()) {
            return $this->successResponse($role, 'Perfil deletado com sucesso!', 200);
        }
    }
    /**
     * Busca informações do Banco de Dados
     *
     * @param string $termo identificador único
     * @param \App\RoleController $role
     * @return \App\Controller\ApiResponser 
     * retorna Json
     */
    public function search($termo)
    {

        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 10;
        $search = "%{$termo}%";
        $roles = Role::whereRaw("unaccent(lower(name)) LIKE unaccent(lower(?))")
            ->setBindings([$search])
            ->paginate($limit);
        $roles->setPath("/roles/search/{$termo}?limit={$limit}");

        return response()->json([
            'success' => true,
            'paginator' => $roles,
        ]);
    }

    /**
     * Seleciona tipo por ID
     * @param int $id idetificador único
     * @param \App\Role\ $role
     * @return \App\Controller\ApiResponser 
     * retorna json
     */
    public function getById($id)
    {
        $tipo = Role::find($id);

        return $this->showOne($tipo);
    }
}
