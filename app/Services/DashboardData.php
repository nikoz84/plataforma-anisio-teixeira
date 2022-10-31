<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardData
{
    protected static $request = null;
    protected static $response = null;

    public static function conteudosPorAno()
    {
        //Carregando a table

        $ordenarPor = self::$request->get('ordenarPor', 'DESC');
        $date = self::$request->get('ano');

        return DB::table('conteudos')
            ->selectRaw('extract(year from conteudos.created_at) as ano, COUNT(*) as total')
            ->when($date, function ($query) use ($date) {
                return $query->whereYear('created_at', $date);
            })
            ->groupByRaw('extract(year from conteudos.created_at)')
            ->orderBy('ano', $ordenarPor)
            ->get();
    }

    public static function filtroAnos()
    { // Carregar o filtro anos

        return DB::table('conteudos')
            ->selectRaw('extract(year from conteudos.created_at) as ano')
            ->groupByRaw('extract(year from conteudos.created_at)')
            ->orderBy('ano', "DESC")
            ->get()->pluck('ano');
    }

    public static function filtroOrdenarPor()
    {
        return [
            'ASC',
            'DESC'
        ];
    }

    public static function aplicativosMaisVisualizados()
    {

        $ordenarPor = self::$request->get('ordenarPor', 'DESC');
        $date = self::$request->get('ano');

        return DB::table('aplicativos')
            ->select(['name', 'options->qt_access as qt_access'])
            ->when($date, function ($query) use ($date) {
                return $query->whereYear('created_at', $date);
            })
            ->limit(10)
            ->orderBy('options->qt_access', 'DESC', $ordenarPor)
            ->get();
    }

    public function filtrosAplicativos()
    {
        return DB::table('aplicativos')
            ->selectRaw('extract(month from aplicativos.created_at) as mes')
            ->groupByRaw('extract(month from aplicativos.created_at)')
            ->orderBy('mes', "DESC")
            ->get()->pluck('mes');
    }


    public static function catalogacaoPorCanal()
    {
        $ordenarPor = self::$request->get('ordenarPor', 'DESC');
        $date = self::$request->get('ano');

        return DB::table('canais AS ca')
            ->select(DB::raw('ca.name, count(ca.id) AS total'))
            ->join('conteudos AS c', 'ca.id', '=', 'c.canal_id')
            ->when($date, function ($query) use ($date) {
                return $query->whereYear('created_at', $date);
            })
            ->groupBy('ca.name')
            ->orderBy('total', 'DESC', $ordenarPor)
            ->get();
    }

    public function filtrosCatalogacaoPorCanal()
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
        $inicio = Carbon::createFromFormat('Y-m-d', self::$request->get('inicio'))->format('d-m-Y');
        $fim = Carbon::createFromFormat('Y-m-d', self::$request->get('fim'))->format('d-m-Y');
        $ordenarPor = self::$request->get('quantidade');

        return DB::table('conteudos')->selectRaw('extract(month from conteudos.created_at) as mes, COUNT(*) as quantidade')
            ->when(!$inicio && !$fim, function ($q) use ($inicio, $fim) {
                return $q->whereBetween('conteudos.created_at', [$inicio, $fim]);
            })
            ->when($ordenarPor, function ($q) use ($ordenarPor) {
                return $q->orderBy('quantidade', [$ordenarPor]);
            })
            ->groupByRaw('extract(month from conteudos.created_at)')
            ->orderBy('quantidade', 'DESC')
            ->get();
    }

    public static function filtroMes()
    { // Carregar o filtro por mês

        return DB::table('conteudos')
            ->selectRaw('extract(month from conteudos.created_at) as mes')
            ->groupByRaw('extract(month from conteudos.created_at)')
            ->orderBy('mes', "DESC")
            ->get()->pluck('mes');
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
            ->limit(10)->get();
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
        return new static;
    }

    public static function getDataFromId($id)
    {
        if ($id) {
            $nameClass = self::class;
            $method = Str::camel($id, '-');
            self::$response = call_user_func("{$nameClass}::{$method}");
        }
        return self::$response;
    }


    public static function getCards()
    {
        return collect([
            ['id' => 'conteudos-por-ano', 'titulo' => 'Conteúdo por ano', 'componente' => 'ConteudosPorAno'],
            ['id' => 'aplicativos-mais-visualizados', 'titulo' => 'Aplicativos mais visualizados', 'componente' => 'AplicativosMaisVisualizados'],
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
