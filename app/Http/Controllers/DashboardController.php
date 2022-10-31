<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Services\DashboardData;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
            'anos' => DashboardData::setRequest($request)->filtroAnos(),
            'ordenarPor' => DashboardData::filtroOrdenarPor(),
        ]);
    }

    public function getFiltrosMes(Request $request, $id)
    {
        return $this->successResponse([
            'mes' => DashboardData::setRequest($request)->filtroMes(),
            'ordenarPor' => DashboardData::filtroOrdenarPor(),
        ]);
    }

    public function getFiltrosAplicativos(Request $request, $id)
    {
        return $this->successResponse([
            'aplicativos' => DashboardData::setRequest($request)->filtrosAplicativos(),
            'ordenarPor' => DashboardData::filtroOrdenarPor(),
        ]);
    }

    public function getFiltroscatalogacaoPorCanal(Request $request, $id)
    {
        return $this->successResponse([
            'aplicativos' => DashboardData::setRequest($request)->filtrosCatalogacaoPorCanal(),
            'ordenarPor' => DashboardData::filtroOrdenarPor(),
        ]);
    }
}
