<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Services\DashboardFiltros;
use App\Services\DashboardData;

class DashboardController extends ApiController
{
    public function getCards()
    {
        return $this->successResponse(DashboardData::getCards());
    }

    public function getById(Request $request, $id)
    {
        $dashboardData = DashboardData::setRequest($request)->getDataFromId($id);

        return $this->successResponse($dashboardData);
    }

    //Chamada da rota
    public function getFiltros(Request $request, $id)
    {
        return $this->successResponse([
            'anos' => DashboardFiltros::filtroAnos(),
            'meses' => DashboardFiltros::filtroMeses(),
            'ordenarPor' => DashboardFiltros::filtroOrdenarPor(),
        ]);
    }
}
