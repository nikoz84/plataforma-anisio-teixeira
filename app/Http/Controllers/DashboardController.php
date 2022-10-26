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

        DashboardData::setRequest($request);
        return $this->successResponse(DashboardData::getDataFromId($id));
    }
}