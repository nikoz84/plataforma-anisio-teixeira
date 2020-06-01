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
            'buscarJsonNoGoogleSpreadsheets',
            'conteudos',
            'buscarJsonRotinaDeEstudosNoGoogleSpreadsheets'
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

    public function conteudos(Request $request)
    {
        $conteudoPlanilha = new ConteudoPlanilha();
        echo json_encode($conteudoPlanilha->conteudos()->paginate($request->query('page')));
    }

    public function buscarJsonRotinaDeEstudosNoGoogleSpreadsheets($googleKey)
    {
        $conteudoPlanilha = new ConteudoPlanilha();
       
        $dados = $conteudoPlanilha->buscarJsonNoGoogleSpreadsheets($googleKey);

        $novaEstrutura = [];
        $semanas = [];
        $dias = [
            'segunda-feira',
            'terca-feira',
            'quarta-feira',
            'quinta-feira',
            'sexta-feira'
        ];

        foreach ($dados['semanas'] as $semana) {
            array_push($semanas, $semana['slug']);
        }

        //dd($semanas);

        foreach ($dados['semanas'] as $semana) {

            //$novaEstrutura['semana'][] = $semana['semana'];

            foreach ($dados['rotinas'] as $k => $rotina) {

                if (in_array($semana['slug'], $semanas) &&  in_array($rotina['dia'], $dias)) {

                    $novaEstrutura['semanas'][$semana['slug']][$rotina['dia']] = [
                        'dia' => $rotina['dia'],
                        'atividade' => $rotina['atividade'],
                        'descricao' => $rotina['descricao'],
                        'sugestao' => $rotina['sugestao'],
                        'link' => $rotina['link'],
                        'nivel-ensino' => $rotina['nivel-ensino']                    ];
                }
            }

        }

        //dd($novaEstrutura);

        echo json_encode($novaEstrutura);
        
    }
}