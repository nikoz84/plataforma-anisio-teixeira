<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Conteudo;
use App\Models\Tag;
use App\Models\Aplicativo;
use App\Models\Canal;
use Google\Service\AnalyticsData\OrderBy;

class DashboardData
{
    public static function getConteudosPorAno(Request $request)
    {
    
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('inicio', ''),
        $request->get('fim', '')])->count();
        
        return [
            'titulo' => 'Conteúdos publicados por ano',
            'quantidade' => $conteudos,
            'fim' => $request->get('fim', ''),
            'inicio' => $request->get('inicio', '')
        ];
    }
    public static function getCatalogacaoMensal(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('inicio', ''),
        $request->get('fim', '')])->count();
        
        return [
        'titulo' => 'Catalogação mensal',
        'quantidade' => $conteudos,
         'fim' => $request->get('fim', ''),
        'inicio' => $request->get('inicio', '')
        ];
    }
    public static function getCatalogacaoPorCanal(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('fim', ''),
        $request->get('inicio', '')])->count();
        
        return [
        'titulo' => 'Catalogação por canal',
        'quantidade' => $conteudos,
         'fim' => $request->get('fim', ''),
        'inicio' => $request->get('inicio', '')
        ];
    }
    public static function getCatalogacaoMensalPorUsuario(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('fim', ''),
        $request->get('inicio', '')])->count();
        return [
        'titulo' => 'Catalogação mensal por usuário',
        'quantidade' => $conteudos,
         'fim' => $request->get('fim', ''),
        'inicio' => $request->get('inicio', '')
        ];
    }
    public static function getCatalogacaoTotalMensal(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('fim', ''),
        $request->get('inicio', '')])->count();
        
        return [
        'titulo' => 'Catalogação total mensal',
         'quantidade' => $conteudos,
         'fim' => $request->get('fim', ''),
         'inicio' => $request->get('inicio', '')
        ];
    }
    public static function getConteudosMaisBaixados(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('fim', ''),
        $request->get('inicio', '')])->count();
        return [
        'titulo' => 'Conteúdos mais baixados',
        'quantidade' => $conteudos,
        'fim' => $request->get('fim', ''),
        'inicio' => $request->get('inicio', '')
        ];
    }
    public static function getConteudosMaisAcessados(Request $request)
    {
        
        $conteudos = Conteudo::whereBetween('created_at',[
        $request->get('inicio', ''),
        $request->get('fim', '')])->count();
        return [
          'titulo' => 'Conteúdos mais acessados',
          'quantidade' => $conteudos,
          'inicio' => $request->get('inicio', ''),
          'fim' => $request->get('fim', ''),
          'category_id'=> $request->get('id', '')
        ];
    }
    public static function getTagsMaisProcuradas(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('fim', ''),
        $request->get('inicio', '')])->count();
        
        return [
         'titulo' => 'Tags mais procuradas',
         'quantidade' => $conteudos,
         'fim' => $request->get('fim', ''),
          'inicio' => $request->get('inicio', ''),
            
        ];
    }
    public static function getAplicativosMaisVizualizados(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('inicio', ''),
        $request->get('fim', '')])->count();
        return [
        'titulo' => 'Aplicativos mais vizualizados',
        'quantidade' => $conteudos,
        'fim' => $request->get('fim', ''),
        'inicio' => $request->get('inicio', ''),
        ];
    }

    public static function getTiposDeMidia(Request $request)
    {
        $conteudos = Conteudo::whereBetween('created_at', [
        $request->get('fim', ''),
        $request->get('inicio', '')])->count();
        return [
        'titulo' => 'Tipos de mídia',
        'quantidade' => $conteudos,
        'fim' => $request->get('fim', ''),
        'inicio' => $request->get('inicio', ''),
        ];
    }
    
}