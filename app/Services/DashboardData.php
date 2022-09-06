<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Conteudo;

class DashboardData
{
    public static function getConteudosPorAno(Request $request)
    {

        $conteudos = Conteudo::whereBetween('created_at', [$request->get('inicio', ''), $request->get('fim', '')])->count();

        return [
            'titulo' => 'Conteúdos publicados por ano',
            'quantidade' => $conteudos,
            'fim' => $request->get('fim', ''),
            'inicio' => $request->get('inicio', '')
        ];
    }
    public static function getCatalogacaoMensal(Request $request)
    {
        return [
            'titulo' => 'Catalogação total mensal',
            'quantidade' => 254
        ];
    }
}
