<?php

namespace App\Http\Controllers;

use App\Services\Analytics;
use App\Http\Controllers\ApiController;
use App\Services\Autocomplete;
use App\Services\SideBar;
use Illuminate\Http\Request;

class HomeController extends ApiController
{
    /**
     * Create a new controller instance.
     * Cria e instância um novo controlador
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth:api')->except(['index', 'getLayout', 'getHomeData', 'autocomplete']);
        $this->request = $request;
    }


    /**
     * Seleciona da tabela options as configurações do layout
     * @return json resposta em json
     */
    public function getLayout()
    {
        //cache()->forget('layout');

        $from_cache = cache()->remember('layout', now()->addMinutes(1440), function () {
            return SideBar::getSideBarAdvancedFilter();
        });

        return response()->json($from_cache);
    }

    /**
     * Método que solicita e analiza a aplicação
     *
     * @return string json
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
     * @return string json
     */
    public function autocomplete()
    {
        $termo = $this->request->query('termo');
        $limit = $this->request->query('limit', 20);
        $per = $this->request->query('por', 'tag');

        $data = new Autocomplete($termo, $limit, $per);
        $paginator = $data->autocomplete();

        return $this->showAsPaginator($paginator);
    }
}