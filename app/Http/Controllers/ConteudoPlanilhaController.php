<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\Helpers\Autocomplete;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileSystemLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\ConteudoPlanilha;

class ConteudoPlanilhaController extends ApiController
{
    use FileSystemLogic;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api')->except([
            'buscarJsonNoGoogleSpreadsheets'
        ]);
        $request = $request;
    }

    public function buscarJsonNoGoogleSpreadsheets($googleKey)
    {
        $conteudoPlanilha = new ConteudoPlanilha();
        $this->create($conteudoPlanilha->formatarJsonEmArray(
            $conteudoPlanilha->buscarJsonNoGoogleSpreadsheets($googleKey)
        ));
    }

    public function create($dados)
    {
        foreach ($dados as $dado) {
            $conteudoPlanilha = new ConteudoPlanilha();
            $conteudoPlanilha->name = $dado['name'];
            $conteudoPlanilha->document = ['actions' => $dado['actions']];

            $conteudoPlanilha->save();
        }
    }
}