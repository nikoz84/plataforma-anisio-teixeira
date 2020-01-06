<?php

namespace App\Http\Controllers;

use App\Helpers\Analytics;
use App\Helpers\Destaques;
use App\Http\Controllers\ApiController;
use App\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Autocomplete;
use App\NivelEnsino;

class HomeController extends ApiController
{
    protected $destaques;
    protected $request;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Destaques $destaques, Request $request)
    {
        $this->middleware('jwt.verify')->except(['index', 'getLayout', 'getHomeData', 'autocomplete']);
        $this->destaques = new $destaques;
        $this->request = $request;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    /**
     * Seleciona da tabela options as configurações do layout
     * @return json resposta em json
     */
    public function getLayout()
    {
        $links = DB::select(DB::raw("SELECT name,
                                    slug,
                                    options->'order_menu' AS order,
                                    options->'back_url_exibir' AS url_exibir
                                    FROM canais
                                    WHERE is_active = ?
                                    ORDER BY options->'order_menu';"), [true]);

        $layout = Options::select("meta_data")->where("name", "like", "layout")->get()->first();
        $data = [
            "layout" => (object) $layout,
            "links" => $links,
            "disciplinas" => $this->getDisciplinas()
        ];
        return response()->json($data, 200);
    }
    private function getDisciplinas()
    {
        $disciplinas = $collect = NivelEnsino::where('id', '=', 5)->with(["components" => function ($q) {
            $q->where('curricular_components.id', '!=', 31)->orderBy('name');
        }])->get()->first();

        return $disciplinas;
    }
    /**
     * Seleciona os destaques da plataforma do helper
     *
     * @return void
     */
    public function getHomeData()
    {
        $data = [
            [
                'title' => 'Conteúdos Recentes',
                'items' => $this->destaques->getConteudosMaisRecentes(),
            ],
            [
                'title' => 'Conteúdos Mais Baixados',
                'items' => $this->destaques->getConteudosMaisBaixados(),
            ],
            [
                'title' => 'Conteúdos Mais Acessados',
                'items' => $this->destaques->getConteudosMaisAcessados(),
            ],
            [
                'title' => 'Conteúdos Destacados',
                'items' => $this->destaques->getConteudosDestaques(),
            ],
            [
                'title' => 'Aplicativos Destacados',
                'items' => $this->destaques->getAplicativosDestaques(),
            ],
            [
                'title' => 'Aplicativos Recentes',
                'items' => $this->destaques->getAplicativosMaisRecentes(),
            ],
        ];

        return $this->successResponse($data, '', 200);
    }

    public function getAnalytics()
    {
        $analitycs = new Analytics($this->request);
        $collect = collect($analitycs->getData());


        return $this->showAll($collect, '', 200);
    }
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
