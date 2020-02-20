<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\CurricularComponent as Componente;
use App\CurricularComponentCategory as Category;
use Illuminate\Http\Request;

class ComponentesController
{
    use ApiResponser;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return $this->showAll(Category::with('componentes')->get());
    }
}
