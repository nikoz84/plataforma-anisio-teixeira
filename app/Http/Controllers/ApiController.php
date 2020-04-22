<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;

class ApiController extends Controller
{
    /**
     * Trait de respostas com métodos comuns para todos os controladores filhos
     */
    use ApiResponser;
    /**
     * Todo o javascript vai se renderizar em essa view
     *
     * @return void
     */
    public function home()
    {
        return view('index');
    }
}
