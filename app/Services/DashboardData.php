<?php

namespace App\Services;

use App\Models\Aplicativo;
use Illuminate\Http\Request;
use App\Models\Conteudo;
use App\Models\Tag;
use App\Models\Tipo;
use Illuminate\Support\Facades\DB;

class DashboardData
{

    public $limit = 1;

    public function __construct($limit = 1)
    {
        $this->limit = $limit;
    }



    public static function conteudosPorAno(Request $request)
    {

        $conteudos = Conteudo::whereBetween('created_at', [
            $request->get('inicio', ''),
            $request->get('fim', '')
        ])->count();

        return [
            'titulo' => 'Conteúdos publicados por ano',
            'quantidade' => $conteudos,
            'fim' => $request->get('fim', ''),
            'inicio' => $request->get('inicio', '')
        ];
    }
    
    public static function catalogacaoPorCanal(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
            $request->get('fim', ''),
            $request->get('inicio', '')
        ])->count();

        return [
            'titulo' => 'Catalogação por canal',
            'quantidade' => $conteudos,
            'fim' => $request->get('fim', ''),
            'inicio' => $request->get('inicio', '')
        ];
    }
    public static function catalogacaoMensalPorUsuario(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
            $request->get('fim', ''),
            $request->get('inicio', '')
        ])->count();
        return [
            'titulo' => 'Catalogação mensal por usuário',
            'quantidade' => $conteudos,
            'fim' => $request->get('fim', ''),
            'inicio' => $request->get('inicio', '')
        ];
    }
    public static function catalogacaoTotalMensal(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
            $request->get('fim', ''),
            $request->get('inicio', '')
        ])->count();

        return [
            'titulo' => 'Catalogação total mensal',
            'quantidade' => $conteudos,
           
        ];
    }
    public static function conteudosMaisBaixados()
    {
        $conteudo = Conteudo::orderBy('qt_downloads', 'desc')->get()->first();
       
            return [
                'titulo' => 'Conteúdo Mais baixado',
                'quantidade' => $conteudo->qt_access,
                'title' => $conteudo->title,
            ];
        
    }

    public static function conteudosMaisAcessados()
    {
        $conteudo = Conteudo::orderBy('qt_access', 'desc')->get()->first();
      
            return [
                'titulo' => 'Conteúdo Mais Acessado',
                'quantidade' => $conteudo->qt_access,
                'title' => $conteudo->title,
         
            ];
    }

    public static function tagsMaisProcuradas()
    {
        $conteudo = Tag::orderBy('searched', 'desc')->get()->first();
       
            return [
                'titulo' => 'Tag mais procurada',
                'quantidade' => $conteudo->searched,
                'title' => $conteudo->name,
            ];
    }

    

    public static function aplicativosMaisVizualizados()
    {
         $aplicativo = Aplicativo::orderby('options->>qt_access', 'DESC')->first();
        
        return [
            'titulo' => 'Aplicativo mais vizualizados',
            'quantidade' => $aplicativo->options['qt_access'],
            'title' => $aplicativo->title,
        ];

    }


    public static function tiposDeMidia()

    {
    $tipo = Tipo::orderby('options->>qt_access', 'DESC')->first();
    
    return [
            'titulo' => 'Tipo de mídia mais vizualizada',
            'quantidade' => $tipo->options['qt_access'],
            'title' => $tipo->name,
        ];
        
      
            
}
}