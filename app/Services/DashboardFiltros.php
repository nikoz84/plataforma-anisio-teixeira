<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardFiltros
{
    public static function filtroMeses()
    {
        return [
            'JANEIRO',
            'FEVEREIRO',
            'MARÇO',
            'ABRIL',
            'MAIO',
            'JUNHO',
            'JULHO',
            'AGOSTO',
            'SETEMBRO',
            'OUTUBRO',
            'NOVEMBRO',
            'DEZEMBRO'
        ];
    }

    public static function filtroTitulo()
    {
        return DB::table('conteudos')
            ->select('title')
            ->limit(10)
            ->orderby('title', "DESC")
            ->get()->pluck('title');
    }

    public static function filtroOrdenarPor()
    {
        return [
            'ASC',
            'DESC'
        ];
    }

    public static function filtroAnos()
    {
        return DB::table('conteudos')
            ->selectRaw('extract(year from conteudos.created_at) as ano')
            ->groupByRaw('extract(year from conteudos.created_at)')
            ->orderBy('ano', "DESC")
            ->get()->pluck('ano');
    }

    public static function filtroUsuario()
    {
        return DB::table('users as u')
            ->whereIn('u.role_id', [1, 2, 3])
            ->get(['name', 'id']);
    }


    public static function filtrosCatalogacaoPorCanal()
    {

        return DB::table('canais AS ca')
            ->select(DB::raw('ca.name, count(ca.id) AS total'))
            ->join('conteudos AS c', 'ca.id', '=', 'c.canal_id')
            ->groupBy('ca.name')
            ->orderBy('total', 'DESC')
            ->get();
    }

    public static function filtrosAplicativos()
    {
        return DB::table('aplicativos')
            ->selectRaw('extract(month from aplicativos.created_at) as mes')
            ->groupByRaw('extract(month from aplicativos.created_at)')
            ->orderBy('mes', "DESC")
            ->get()->pluck('mes');
    }
}
