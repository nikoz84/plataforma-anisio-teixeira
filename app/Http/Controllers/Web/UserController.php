<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     *Lista de Usuários
     *@param void
     *@return $array
     */
    public function index()
    {
        $paginator = User::paginate(10);

        return Inertia::render('Dashboard/ListUsers', [
            'paginator' => $paginator
        ]);
    }
}
