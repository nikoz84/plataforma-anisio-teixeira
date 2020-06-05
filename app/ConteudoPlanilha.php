<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\UserCan;
use Illuminate\Support\Facades\Auth;

class ConteudoPlanilha extends Model
{
    use SoftDeletes, UserCan;

    protected $table = 'conteudos_planilha';
    protected $casts = ['document' => 'array']; 

    protected $fillable = [
        'name',
        'document'
    ];
    
    /**
    * Metodo usado para 
    */
    public function buscarJsonNoGoogleSpreadsheets($googleKey)
    {
        $url = "https://script.googleusercontent.com/macros/";
        $param = "echo?user_content_key=";
        $routeToGoogle = $url.$param.$googleKey;

        $jsonFile = file_get_contents($routeToGoogle);
        $jsonStr = json_decode($jsonFile, true);
        return $jsonStr['result'];
    }

    public function formatarJsonFaculdadesDaBahia($dados)
    {
        $novaEstrutura = [];
        $ids = [];

        foreach($dados as $key => $dado) {
            if ( ! in_array($dado['id'], $ids)) {
                array_push($ids, $dado['id']);
            }
        }

        foreach($dados as $key => $dado) {
            for ($i = 0; $i < count($ids); $i++) {
                if ($dado['id'] == $ids[$i]) {
                    $novaEstrutura[$i]['name'] = $dado['faculdade'];
                    $novaEstrutura[$i]['actions'][] = [
                        'name' => $dado['nome'],
                        'description' => $dado['descricao'],
                        'link' => $dado['link']
                    ];
                }
            }
        }

        return $novaEstrutura;
    }

    public function formatarJsonRotinasDeEstudo($dados)
    {
        $novaEstrutura = [];
        $semanas = [];
        $dias = $this->diasDaSemanaPorExtenso();

        foreach ($dados['semanas'] as $semana) {
            array_push($semanas, $semana['slug']);
        }

        foreach ($dados['semanas'] as $key => $semana) {
            foreach ($dados['rotinas'] as $rotina) {
                if (in_array($semana['slug'], $semanas) && in_array($rotina['dia'], $dias)) {
                    $novaEstrutura['rotinas'][$key][$semana['slug']][$rotina['dia']][$rotina['nivel-ensino']]['atividades'][] = [
                        'descricao' => $rotina['descricao'],
                        'link' => $rotina['link'],
                        'sugestao' => $rotina['sugestao']                
                    ];
                }
            }
        }

        return $novaEstrutura;
    }

    public function conteudos()
    {
    	return $this->select();
    }

    public function diasDaSemanaPorExtenso()
    {
        return  [
            'segunda-feira',
            'terca-feira',
            'quarta-feira',
            'quinta-feira',
            'sexta-feira'
        ];
    }
}