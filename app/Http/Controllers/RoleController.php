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
        //
    }
    public function update()
    {
        //
    }
    public function delete()
    {
        //
    }
}
