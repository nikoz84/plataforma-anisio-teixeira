<?php

namespace App\Http\Controllers;

use App\Tipo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TipoController extends ApiController
{
    public function __construct(Tipo $tipo, Request $request)
    {
        $this->middleware('jwt.verify')->except(['list']);
        $this->tipo = $tipo;
        $this->request = $request;
    }

    public function list()
    {
        $tipos = $this->tipo::all();

        return $this->showAll($tipos, '', 200);
    }
}
