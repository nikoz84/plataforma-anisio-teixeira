<?php

namespace App\Services;

use App\Models\Aplicativo;
use App\Models\Conteudo;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class DashboardData
{

    public static function conteudosPorAno()
    {
        $conteudo = Conteudo::selectRaw('extract(year from conteudos.created_at) as ano, COUNT(*) as quantidade')
            ->groupByRaw('extract(year from conteudos.created_at)')
            ->orderBy('quantidade', 'DESC')
            ->get()->first();

        return [
            'titulo' => 'Conteúdos por ano',
            'quantidade' => $conteudo->quantidade,
            'title' => $conteudo->ano
        ];
    }

    public static function catalogacaoPorCanal()
    {
        $canal = DB::table('canais AS ca')
            ->select(DB::raw('ca.name, count(ca.id) AS total'))
            ->join('conteudos AS c', 'ca.id', '=', 'c.canal_id')
            ->groupBy('ca.name')
            ->orderBy('total', 'DESC')
            ->get()->first();

        return [
            'titulo' => 'Catalogação por canal',
            'quantidade' => $canal->total,
            'title' => $canal->name
        ];
    }
    public static function catalogacaoMensalPorUsuario()
    {
        $user = DB::table('users as u')
            ->select(DB::raw('u.name, count(u.id) AS total'))
            ->join('conteudos AS c', 'u.id', '=', 'c.user_id')
            ->groupBy('u.name')
            ->orderBy('total', 'DESC')
            ->get()->first();
        return [
            'titulo' => 'Catalogação mensal por usuário',
            'quantidade' => $user->total,
            'title' => $user->name

        ];
    }
    public static function catalogacaoTotalMensal()
    {
        $conteudo = Conteudo::selectRaw('extract(month from conteudos.created_at) as mes, COUNT(*) as quantidade')
            ->groupByRaw('extract(month from conteudos.created_at)')
            ->orderBy('quantidade', 'DESC')
            ->get()->first();

        return [
            'titulo' => 'Catalogação total mensal',
            'quantidade' => $conteudo->quantidade,
            'title' => $conteudo->mes
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
            'titulo' => 'Conteúdo mais Acessado',
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
        $tipo = DB::table('tipos AS t')
            ->select(DB::raw('t.name, count(t.id) AS total'))
            ->join('conteudos AS c', 't.id', '=', 'c.tipo_id')
            ->groupBy('t.name')
            ->orderBy('total', 'DESC')
            ->get()->first();

        return [
            'titulo' => 'Mídia mais vizualizada',
            'quantidade' => $tipo->total,
            'title' => $tipo->name
        ];
    }
}