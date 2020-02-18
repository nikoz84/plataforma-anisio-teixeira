<?php

namespace App\Http\Controllers;

use App\Helpers\Analytics;
use App\Helpers\Destaques;
use App\Http\Controllers\ApiController;
use App\Helpers\Autocomplete;
use App\Helpers\SideBar;
use App\NivelEnsino;

class HomeController extends ApiController
{
    protected $destaques;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Destaques $destaques)
    {
        $this->middleware('jwt.verify')->except(['index', 'getLayout', 'getHomeData', 'autocomplete']);
        $this->destaques = new $destaques;
    }


    /**
     * Seleciona da tabela options as configurações do layout
     * @return json resposta em json
     */
    public function getLayout()
    {
        return response()->json(SideBar::getSideBarAdvancedFilter());
    }


    /**
     * Seleciona os destaques da plataforma do helper
     *
     * @return void
     */
    public function getHomeData($slug)
    {
        $destaques = new Destaques();
        $data = $destaques->getHomeDestaques($slug);

        return $this->successResponse($data, '', 200);
    }
    /**
     * Método que solicita analitica da aplicação
     *
     * @return void
     */
    public function getAnalytics()
    {
        $analitycs = new Analytics($this->request);
        $collect = collect($analitycs->getData());


        return $this->showAll($collect, '', 200);
    }
    /**
     * Método de autocompletar
     *
     * @return void
     */
    public function autocomplete()
    {
        $termo = $this->request->query('termo');
        $limit = $this->request->query('limit', 20);
        $per = $this->request->query('por', 'tag');

        $data = new Autocomplete($termo, $limit, $per);
        $paginator = $data->autocomplete();

        return $this->showAsPaginator($paginator, '', 200);
    }
}
