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
                'data' => DashboardData::conteudosPorAno($request)
            ],
        
            [
                'id' => 'catalogacao-por-canal',
                'data' => DashboardData::catalogacaoPorCanal($request)
            ],
            [
                'id' => 'catalogacao-mensal-por-usuario',
                'data' => DashboardData::catalogacaoMensalPorUsuario($request)
            ],
            [
                'id' => 'catalogacao-total-mensal',
                'data' => DashboardData::catalogacaoTotalMensal($request)
            ],
             [
                'id' => 'conteudos-mais-baixados',
                'data' => DashboardData::conteudosMaisBaixados($request)
            ],
            [
                'id' => 'conteudos-mais-acessados',
                'data' => DashboardData::conteudosMaisAcessados($request)
            ],
            [
                'id' => 'tags-mais-procuradas',
                'data' => DashboardData::tagsMaisProcuradas($request)
            ],
            [
                 'id' => 'aplicativos-mais-vizualizados',
                'data' => DashboardData::aplicativosMaisVizualizados($request)
            ],
            [
                'id' => 'tipos-de-midia',
                'data' => DashboardData::tiposDeMidia($request)
            ],

        ]);
    }
}