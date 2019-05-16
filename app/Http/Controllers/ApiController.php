<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\ValidaForm;
//use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ApiResponser, ValidaForm;

    /*
    protected $request;

    public function __construct(Request $_request)
    {
        $this->request = $_request;
    }
    */
}
