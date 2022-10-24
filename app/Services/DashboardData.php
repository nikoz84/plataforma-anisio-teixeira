<?php

namespace App\Services;

use App\Models\Aplicativo;
use App\Models\Conteudo;
use App\Models\Tag;
use App\Services\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardData
{
    protected static $request = null;

    public static function conteudosPorAno()
    {
        return DB::table('conteudos')
            ->selectRaw('extract(year from conteudos.created_at) as ano, COUNT(*) as total')
            ->groupByRaw('extract(year from conteudos.created_at)')
            ->orderBy('total', 'DESC')
            ->get();
    }


    public static function aplicativosMaisVisualizados()
    {
        return DB::table('aplicativos')
            ->select(['name', 'options->qt_access as qt_access'])
            ->limit(10)
            ->orderBy('options->qt_access', 'DESC')
            ->get();
    }


    public static function catalogacaoPorCanal()
    {
        return DB::table('canais AS ca')
            ->select(DB::raw('ca.name, count(ca.id) AS total'))
            ->join('conteudos AS c', 'ca.id', '=', 'c.canal_id')
            ->groupBy('ca.name')
            ->orderBy('total', 'DESC')
            ->get();
    }
    public static function catalogacaoMensalPorUsuario()
    {
        return DB::table('users as u')
            ->select(DB::raw('u.name, count(u.id) AS total'))
            ->join('conteudos AS c', 'u.id', '=', 'c.user_id')
            ->limit(10)
            ->groupBy('u.name')
            ->orderBy('total', 'DESC')
            ->get();
    }
    public static function catalogacaoTotalMensal()
    {

        return DB::table('conteudos')->selectRaw('extract(month from conteudos.created_at) as mes, COUNT(*) as quantidade')
            ->groupByRaw('extract(month from conteudos.created_at)')
            ->orderBy('quantidade', 'DESC')
            ->get();
    }
    public static function conteudosMaisBaixados()
    {
        return DB::table('conteudos')->select(['title', 'qt_downloads'])->limit(10)->orderBy('qt_downloads', 'desc')->get();
    }

    public static function conteudosMaisAcessados()
    {
        return DB::table('conteudos')->select(['title', 'qt_access'])->limit(10)->orderBy('qt_access', 'desc')->get();
    }

    public static function tagsMaisProcuradas()
    {
        return DB::table('tags')
            ->select(['name', 'searched'])
            ->orderBy('searched', 'desc')
            ->limit(15)->get();
    }




    public static function tiposDeMidia()
    {
        return DB::table('tipos AS t')
            ->select(DB::raw('t.name, count(t.id) AS total'))
            ->join('conteudos AS c', 't.id', '=', 'c.tipo_id')
            ->limit(10)
            ->groupBy('t.name')
            ->orderBy('total', 'DESC')
            ->get();
    }


    public static function setRequest(Request $request)
    {

        self::$request = $request;
    }

    public static function getDataFromId($id)
    {

        if ($id) {
            $nameClass = self::class;
            $method = Str::camel($id, '-');
            $resposta = call_user_func("{$nameClass}::{$method}");

            return $resposta;
        }
    }

    public static function getCards()
    {
        return collect([
            ['id' => 'conteudos-por-ano', 'titulo' => 'Conteúdo por ano', 'componente' => 'ConteudosPorAno'],
            ['id' => 'aplicativos-mais-visualizados', 'titulo' => 'Aplicativo mais vizualizados', 'componente' => 'AplicativosMaisVisualizados'],
            ['id' => 'catalogacao-por-canal', 'titulo' => 'Catalogação por canal', 'componente' => 'CatalogacaoPorCanal'],
            ['id' => 'catalogacao-mensal-por-usuario', 'titulo' => 'Catalogação mensal por usuário', 'componente' => 'CatalogacaoMensalPorUsuario'],
            ['id' => 'catalogacao-total-mensal', 'titulo' => 'Catalogação total mensal', 'componente' => 'CatalogacaoTotalMensal'],
            ['id' => 'conteudos-mais-baixados', 'titulo' => 'Conteúdo mais baixado', 'componente' => 'ConteudoMaisBaixados'],
            ['id' => 'conteudos-mais-acessados', 'titulo' => 'Conteúdo mais acessado', 'componente' => 'ConteudosMaisAcessados'],
            ['id' => 'tags-mais-procuradas', 'titulo' => 'Palavra-chave mais procurada', 'componente' => 'TagsMaisProcuaradas'],
            ['id' => 'tipos-de-midia', 'titulo' => 'Tipo de mídia', 'componente' => 'TiposDeMidia'],
        ]);
    }
}
