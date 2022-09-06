<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Services\DashboardData;

class DashboardController extends ApiController
{


    public function index(Request $request)
    {
        return $this->successResponse([
            [
                'id' => 'conteudos-por-ano',
                'data' => DashboardData::getConteudosPorAno($request)
            ],
            [
                'id' => 'catalogacao-mensal',
                'data' => DashboardData::getCatalogacaoMensal($request)
            ]
        ]);
    }
}
