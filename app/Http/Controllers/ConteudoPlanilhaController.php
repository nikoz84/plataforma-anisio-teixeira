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
        $dados = $conteudoPlanilha->buscarJsonNoGoogleSpreadsheets($googleKey);

        //dd($conteudoPlanilha->formatarJson($dados));
        $this->create($conteudoPlanilha->formatarJson($dados));
    }

    public function create($dados)
    {
    	$conteudoPlanilha = new ConteudoPlanilha();
    	$conteudoPlanilha->name = 'teste';
    	$conteudoPlanilha->document = ['teste' => 'testando'];

    	$conteudoPlanilha->save();

    	

    }
}