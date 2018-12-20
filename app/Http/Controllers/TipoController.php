<?php

namespace App\Http\Controllers;

use App\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoController extends Controller
{
    public function __construct(Tipo $tipo, Request $request)
    {
        $this->middleware('jwt.verify')->except([
            'list'
        ]);
        $this->tipo = $tipo;
        $this->request = $request;
    }

    public function list()
    {
        $tipos = $this->tipo::all();
        return response()->json([
            'success' => true,
            'tipos' => $tipos,
        ]);
    }
}
