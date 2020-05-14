<?php

namespace App\Http\Controllers;

use App\Role;
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

    public function index()
    {
        if ($this->request->has('select')) {
            $select = $this->role::all();
            return $this->successResponse($select, '', 200);
        }
        $roles = $this->role::paginate();
        return $this->showAsPaginator($roles, '', 200);
    }
    public function create()
    {
        $validator = Validator::make($this->request->all(), ["name" => "required"]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o perfil", 201);
        }
        $role = $this->role;
        $role->name = $this->request->name;
        if ($role->save()) {
            return $this->successResponse($role, 'Perfil criado com sucesso!', 200);
        }
    }
    public function update(Request $request, $id)
    {
        $role = $this->role::find($id);

        $this->authorize('delete', $role);

        $validator = Validator::make($this->request->all(), ["name" => "required"]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o perfil", 201);
        }
        $role = $this->role;
        $role->name = $this->request->name;

        $role->fill($this->request->all());
        if ($role->update()) {
            return $this->successResponse($role, 'Perfil editado com sucesso!', 200);
        }
    }
    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível deletar.", 201);
        }
        $role = $this->role;
        $resp = $this->role::find($id);
        if (Gate::denies('super-admin', $resp)) {
            return $this->errorResponse([], 'Usuário sem permissão de acesso!', 403);
        }
        if ($resp->delete()) {
            return $this->successResponse($role, 'Perfil deletado com sucesso!', 200);
        }
    }
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
}
