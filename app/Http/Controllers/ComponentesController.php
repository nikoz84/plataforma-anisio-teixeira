<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\CurricularComponent as Componente;
use App\CurricularComponent;
use App\CurricularComponentCategory as Category;
use Illuminate\Http\Request;

class ComponentesController
{
    use ApiResponser;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Mostra toda as informações do Aplicativo no banco de dados.
     * 
     * @param \App\Componentes $componentes
     * @param \App\Controller\Api Responser
     * retorna json
     * @return
     * 
     */
    public function index()
    {
        return $this->showAll(CurricularComponent::with('categories')->get());
    }

    public function create(Componente $componente)
    {
        print_r($componente);
    }

    public function rules()
    {
        return [

        ];
    }
}
