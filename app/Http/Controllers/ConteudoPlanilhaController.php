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
            'getFaculdadesDaBahia',
            'conteudos',
            'getRotinaDeEstudos'
        ]);
        $request = $request;
    }

    public function getFaculdadesDaBahia()
    {
        $url = "AKfycbyewWsCp5HdbrkQwRSMyeRAsQiRc8PtjeyOrS07drrzxdpjb7HA/exec";

        $conteudoPlanilha = new ConteudoPlanilha();
        $this->createFaculdadesDaBahia($conteudoPlanilha->formatarJsonFaculdadesDaBahia(
            $conteudoPlanilha->buscarJsonNoGoogleSpreadsheets($url)
        ));
    }

    public function getRotinaDeEstudos($semana)
    {
        $url = "AKfycbzwTW7RUANw0j8CjCIxnWLCQ3QHjiTbCbYapV5frwXyn8UmBdh2/exec?semana={$semana}";
        $conteudoPlanilha = new ConteudoPlanilha();
        $this->createRotinasDeEstudo($conteudoPlanilha->formatarJsonRotinasDeEstudo(
            $conteudoPlanilha->buscarJsonNoGoogleSpreadsheets($url)
        ));
    }

    public function createFaculdadesDaBahia($dados)
    {
        foreach ($dados as $dado) {
            $conteudoPlanilha = new ConteudoPlanilha();
            $conteudoPlanilha->name = $dado['name'];
            
            $conteudoPlanilha->document = [
                'faculdade' => $dado['faculdade'],
                'slug' => $dado['slug'],
                'actions' => $dado['actions']];

            $conteudoPlanilha->save();
        }
    }

    public function createRotinasDeEstudo($dados)
    {
        foreach ($dados['rotinas'] as $arrayDados) {
            $conteudoPlanilha = new ConteudoPlanilha();
            $semanas = array_keys($arrayDados)[0];
            $conteudoPlanilha->name = $semanas;

            foreach ($arrayDados as $dado) {
                $conteudoPlanilha->document = ['actions' => $dado];
            }

            $conteudoPlanilha->save();
        }
    }

    public function conteudos(Request $request)
    {
        $query = ConteudoPlanilha::query();
        $conteudoPlanilha = $query->where('name', $request->slug)->paginate(15);
        
        return $this->showAsPaginator($conteudoPlanilha);
    }
}
