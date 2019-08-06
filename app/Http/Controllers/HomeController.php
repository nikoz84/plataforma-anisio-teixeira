<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Options;
use App\Helpers\Destaques;
use Illuminate\Http\Request;
use App\Helpers\WordpressService;

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
        $this->middleware('jwt.verify')->except(['index', 'getLayout', 'getHomeData']);
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
            "layout" => (object)$layout,
            "links" => $links
        ];
        return response()->json($data, 200);
    }

    public function getHomeData()
    {
        $data = [
            [
                'title' => 'Conteúdos Recentes',
                'items' => $this->destaques->getConteudosMaisRecentes()
            ],
            [
                'title' => 'Conteúdos Mais Baixados',
                'items' => $this->destaques->getConteudosMaisBaixados()
            ],
            [
                'title' => 'Conteúdos Mais Acessados',
                'items' => $this->destaques->getConteudosMaisAcessados()
            ],
            [
                'title' => 'Conteúdos Destacados',
                'items' => $this->destaques->getConteudosDestaques()
            ],
            [
                'title' => 'Aplicativos Destacados',
                'items' => $this->destaques->getAplicativosDestaques()
            ],
            [
                'title' => 'Aplicativos Recentes',
                'items' => $this->destaques->getAplicativosMaisRecentes()
            ]
        ];
        return $this->successResponse( $data,'', 200 );
    }

    public function getAnalytics()
    {
        $wordpress = new WordpressService($this->request);

        return response()->json($wordpress->getCatalogacao(), 200);
    }
}
