<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Services\DashboardData;

class DashboardController extends ApiController
{
    public function index(Request $request)
    {
        DashboardData::setRequest($request);
        if ($request->get('id')) {
            $data = DashboardData::getDatafromId();
        } else {
            $data = DashboardData::getAll();
        }

        return $this->successResponse($data);
    }
}