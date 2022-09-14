<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Services\DashboardData;

class DashboardController extends ApiController
{
    public function index(Request $request)
    {
        return $this->successResponse([
            [
                'id' => 'conteudos-por-ano',
                'data' => DashboardData::getConteudosPorAno($request)
            ],
            [
                'id' => 'catalogacao-mensal',
                'data' => DashboardData::getCatalogacaoMensal($request)
            ],
            [
                'id' => 'catalogacao-por-canal',
                'data' => DashboardData::getCatalogacaoPorCanal($request)
            ],
            [
                'id' => 'catalogacao-mensal-por-usuario',
                'data' => DashboardData::getCatalogacaoMensalPorUsuario($request)
            ],
            [
                'id' => 'catalogacao-total-mensal',
                'data' => DashboardData::getCatalogacaoTotalMensal($request)
            ],
             [
                'id' => 'conteudos-mais-baixados',
                'data' => DashboardData::getConteudosMaisBaixados($request)
            ],
            [
                'id' => 'conteudos-mais-acessados',
                'data' => DashboardData::getConteudosMaisAcessados($request)
            ],
            [
                'id' => 'tags-mais-procuradas',
                'data' => DashboardData::getTagsMaisProcuradas($request)
            ],
            [
                 'id' => 'aplicativos-mais-vizualizados',
                'data' => DashboardData::getAplicativosMaisVizualizados($request)
            ],
            [
                'id' => 'tipos-de-midia',
                'data' => DashboardData::getTiposDeMidia($request)
            ],

        ]);
    }
}