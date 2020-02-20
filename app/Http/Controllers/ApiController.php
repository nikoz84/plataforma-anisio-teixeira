<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;

class ApiController extends Controller
{
    // Trait com métodos comuns para todos os controladores filhos \\
    use ApiResponser;
    /**
     * Todo o javascript vai se renderizar em essa view
     *
     * @return void
     */
    public function index()
    {
        return view('index');
    }
}
