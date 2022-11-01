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
            'mes' => DashboardData::setRequest($request)->filtroMes(),
            'nome' => DashboardData::setRequest($request)->filtroUsuario(),
            'titulo' => DashboardData::setRequest($request)->filtroTitulo()

        ]);
    }
}