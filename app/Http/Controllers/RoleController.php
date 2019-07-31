<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class RoleController extends ApiController
{
    private $role;

    public function __construct(Request $request, Role $role)
    {
        $this->middleware('jwt.verify')->except([
            'list', 'search', 'getById',
        ]);
        $this->role = $role;
        $this->request = $request;
    }

    public function list()
    {
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
        if($role->save()){
            return $this->successResponse($role, 'Perfil criado com sucesso!', 200);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($this->request->all(), ["name" => "required"]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o perfil", 201);
        }
        $role = $this->role;
        $role->name = $this->request->name;

        $role = $this->role::find($id);
        $role->fill($this->request->all());
        if($role->update()){
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
        if( $resp->delete() ){
            return $this->successResponse($role, 'Perfil deletado com sucesso!', 200);
        }
    }
}
