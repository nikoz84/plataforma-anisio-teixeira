<?php

namespace App\Services;

use App\Models\Aplicativo;
use App\Models\Conteudo;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardData
{
    protected static $request = null;

    public static function conteudosPorAno()
    {
        $conteudo = Conteudo::selectRaw('extract(year from conteudos.created_at) as ano, COUNT(*) as quantidade')
            ->groupByRaw('extract(year from conteudos.created_at)')
            ->orderBy('quantidade', 'DESC')
            ->get();

        return self::setHeader($conteudo, 'Conteúdos por ano');
    }

    public static function catalogacaoPorCanal()
    {
        $canal = DB::table('canais AS ca')
            ->select(DB::raw('ca.name, count(ca.id) AS total'))
            ->join('conteudos AS c', 'ca.id', '=', 'c.canal_id')
            ->groupBy('ca.name')
            ->orderBy('total', 'DESC')
            ->get();

        return self::setHeader($canal, 'Catalogação por canal');
    }
    public static function catalogacaoMensalPorUsuario()
    {
        $user = DB::table('users as u')
            ->select(DB::raw('u.name, count(u.id) AS total'))
            ->join('conteudos AS c', 'u.id', '=', 'c.user_id')
            ->groupBy('u.name')
            ->orderBy('total', 'DESC')
            ->get();
        return self::setHeader($user, 'Catalogação mensal por usuário');
    }
    public static function catalogacaoTotalMensal()
    {
        $conteudo = Conteudo::selectRaw('extract(month from conteudos.created_at) as mes, COUNT(*) as quantidade')
            ->groupByRaw('extract(month from conteudos.created_at)')
            ->orderBy('quantidade', 'DESC')
            ->get();

        return self::setHeader($conteudo, 'Catalogação total mensal');
    }
    public static function conteudosMaisBaixados()
    {
        $conteudo = Conteudo::orderBy('qt_downloads', 'desc')->get();

        return self::setHeader($conteudo, 'Conteúdos Mais baixado');
    }

    public static function conteudosMaisAcessados()
    {
        $conteudo = Conteudo::orderBy('qt_access', 'desc')->get();

        return self::setHeader($conteudo, 'Conteúdos mais Acessado');
    }

    public static function tagsMaisProcuradas()
    {
        $tags = Tag::orderBy('searched', 'desc')->get();

        return self::setHeader($tags, 'Palavras-chave mais procurada');
    }


    public static function aplicativosMaisVisualizados()
    {
        $aplicativo = Aplicativo::orderby('options->>qt_access', 'DESC')->get();

        return self::setHeader($aplicativo, 'Aplicavos mais visualizadoss');
    }


    public static function tiposDeMidia()
    {
        $tipo = DB::table('tipos AS t')
            ->select(DB::raw('t.name, count(t.id) AS total'))
            ->join('conteudos AS c', 't.id', '=', 'c.tipo_id')
            ->groupBy('t.name')
            ->orderBy('total', 'DESC')
            ->get();

        return self::setHeader($tipo, 'Mídias mais visualizadas');
    }


    public static function setRequest(Request $request)
    {
        self::$request = $request;
    }

    public static function setHeader($data, $title)
    {
        return [
            'data' => $data,
            'titulo' => $title,
        ];
    }

    public static function getDataFromId()
    {
        $id = self::$request->get('id', '');
        if ($id) {
            $nameClass = self::class;
            $method = Str::camel($id, '-');
            $resposta = call_user_func("{$nameClass}::{$method}");
            return $resposta;
        }
    }

    public static function getAll()
    {
        $ids = collect([
            'conteudos-por-ano', 'catalogacao-por-canal', 'catalogacao-mensal-por-usuario', 'catalogacao-total-mensal',
            'conteudos-mais-baixados', 'conteudos-mais-acessados', 'tags-mais-procuradas', 'aplicativos-mais-visualizados', 'tipos-de-midia'
        ]);

        $methods = $ids->map(function ($item) {
            $nameClass = self::class;
            $method = Str::camel($item, '-');
            $resposta = call_user_func("{$nameClass}::{$method}");

            return $resposta;
        });

        return $methods;
    }
}