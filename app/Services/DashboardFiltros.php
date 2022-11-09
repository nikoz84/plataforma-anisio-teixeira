<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardFiltros
{
    public static function filtroMeses()
    {
        return [
            'JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'
        ];
    }

    public static function filtroTitulo()
    {
        return DB::table('conteudos')
            ->select('title')
            ->Limit(10)
            ->orderBy('title', "DESC")
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
    { // Carregar o filtro anos

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
}