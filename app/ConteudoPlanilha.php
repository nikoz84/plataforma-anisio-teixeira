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
    * Consulta ao Google Scripts
    */
    public function getGoogleSpreadsheetsData($url)
    {
        if (!$url) {
            return;
        }
        $baseUrl = "https://script.google.com/macros/s/" . $url;
        $jsonFile = file_get_contents($baseUrl);
        $jsonStr = json_decode($jsonFile, true);
        return $jsonStr['result'];
    }
      /**
       * Retorna dados Formatados em Json 
       *
       * @param [String] $dados
       * @return void
       */
    public function formatarJsonFaculdadesDaBahia($dados)
    {
        $novaEstrutura = [];
        $ids = [];

        foreach ($dados as $key => $dado) {
            if (! in_array($dado['id'], $ids)) {
                array_push($ids, $dado['id']);
            }
        }
        
        foreach ($dados as $key => $dado) {
            for ($i = 0; $i < count($ids); $i++) {
                if ($dado['id'] == $ids[$i]) {
                    $novaEstrutura[$i]['name'] = 'ipes';
                    $novaEstrutura[$i]['slug'] = Str::slug($dado['faculdade'], '-');
                    $novaEstrutura[$i]['faculdade'] =  $dado['faculdade'];
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
       /**
        * Retorna Rotinas de estudo Com Json Formatado 
        *
        * @param [String] $dados
        * @return void
        */
    public function formatarJsonRotinasDeEstudo($dados)
    {
        $novaEstrutura = [];
        $dias = $this->diasDaSemanaPorExtenso();
        $niveis = $this->niveisEnsino();

        foreach ($dados['rotinas'] as $key => $rotina) {
            if (in_array($rotina['dia'], $dias) && in_array($rotina['nivel-ensino'], $niveis)) {
                $novaEstrutura['rotinas'][$rotina['dia']][$rotina['nivel-ensino']][] = [
                    'descricao' => $rotina['descricao'],
                    'link' => $rotina['link'],
                    'sugestao' => $rotina['sugestao']
                ];
            }
        }
        
        return $novaEstrutura;
    }
     /**
      * Retorna conteudos Listados
      *
      * @return void
      */
    public function conteudos()
    {
        return $this->select();
    }
    /**
     * Retorna Niveis de Ensino
     *
     * @return void
     */
    public function niveisEnsino()
    {
        return [
            'ensino-medio',
            'ensino-fundamental-1',
            'ensino-fundamental-2',
        ];
    }
    /**
     * Retorna Dias da semana
     *
     * @return void
     */
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
