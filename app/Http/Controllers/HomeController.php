<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Options;
use App\Helpers\Destaques;
use Illuminate\Http\Request;

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
        $get = $this->request->query('get', 'conteudos_recentes');
        $data = [];

        switch ($get) {
            case 'conteudos_recentes':
                $data = [
                    'title' => 'Conteúdos Recentes',
                    'items' => $this->destaques->getConteudosMaisRecentes()
                ];
                break;
            case 'conteudos_baixados':
                $data = [
                    'title' => 'Conteúdos Mais Baixados',
                    'items' => $this->destaques->getConteudosMaisBaixados(),
                ];
                break;
            case 'conteudos_acessados':
                $data = [
                    'title' => 'Conteúdos Mais Acessados',
                    'items' => $this->destaques->getConteudosMaisAcessados(),
                ];
                break;
            case 'conteudos_destacados':
                $data = [
                    'title' => 'Conteúdos Destacados',
                    'items' => $this->destaques->getConteudosDestaques(),
                ];
                break;
            case 'aplicativos_recentes':
                $data = [
                    'title' => 'Aplicativos Recentes',
                    'items' => $this->destaques->getAplicativosMaisRecentes(),
                ];
                break;
            case 'aplicativos_destacados':
                $data = [
                    'title' => 'Aplicativos Destacados',
                    'items' => $this->destaques->getAplicativosDestaques(),
                ];
                break;
        }

        return response()->json($data, 200);
    }
}
