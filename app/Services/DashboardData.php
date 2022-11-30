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

        $ordenarPor = self::$request->get('ordenarPor', 'ASC');
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
        $ordenarPor = self::$request->get('ordenarPor', 'DESC');
        $usuario_id = self::$request->get('id');
        $mes = self::$request->get('mes');
        $ano = self::$request->get('ano');

        $limit = self::$request->get('limit');

        return DB::table('users as u')
            ->select(DB::raw("u.name, 
                count(u.id) AS total, 
                upper(to_char(c.created_at, 'TMMonth')) as mes,  
                row_number() OVER () AS id, 
                extract(YEAR from c.created_at) as ano"))
            ->join('conteudos AS c', 'u.id', '=', 'c.user_id')
            ->when($usuario_id, function ($query) use ($usuario_id) {
                return $query->where('u.id', '=', $usuario_id);
            })
            ->when($mes, function ($query) use ($mes) {
                return $query->whereRaw("upper(to_char(c.created_at, 'TMMonth')) = '{$mes}'");
            })
            ->when($ano, function ($query) use ($ano) {
                return $query->whereRaw("extract(YEAR from c.created_at) = {$ano}");
            })
            ->groupByRaw("upper(to_char(c.created_at, 'TMMonth')), ano")
            ->groupBy('u.name')
            ->orderBy('total', $ordenarPor)
            ->paginate($limit);
    }

    public static function catalogacaoTotalMensal()
    {
        $start = self::$request->get('start');
        $end = self::$request->get('end');
        $ordenarPor = self::$request->get('ordenarPor', 'DESC');
        
        return DB::table('conteudos')
            ->selectRaw("to_char(conteudos.created_at,'TMMONTH') as periodo, 
            COUNT(*) as quantidade")
            ->when($start && $end, function ($q) use ($start, $end) {
                return $q->whereBetween('conteudos.created_at', [$start, $end]);
            })

            ->groupByRaw("to_char(conteudos.created_at,'TMMONTH')")
            ->orderBy('mes', 'ASC', $ordenarPor)
            ->get();
    }



    public static function conteudosMaisBaixados()
    {
        return DB::table('conteudos')
            ->select(['title', 'qt_downloads'])
            ->limit(10)->orderBy('qt_downloads', 'desc')
            ->get();
    }


    public static function conteudosMaisAcessados()
    {
        return DB::table('conteudos')
            ->select(['title', 'qt_access'])
            ->limit(10)
            ->orderBy('qt_access', 'desc')
            ->get();
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
