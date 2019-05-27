<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Options;
use App\Conteudo;
use App\Aplicativo;

class HomeController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verify')->except(['index', 'getLayout', 'getHomeData']);
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
                                    options->'back_url' AS url
                                    FROM canais
                                    WHERE is_active = ?
                                    ORDER BY options->'order_menu';"), [true]);

        $layout = Options::select("meta_data")->where("name", "like", "layout")->get();
        $data = [
            "layout" => (object)$layout[0],
            "links" => $links
        ];
        return response()->json($data, 200);
    }
    public function getHomeData()
    {
        $data = [
            'conteudos_recentes' => $this->getConteudosMaisRecentes(),
            'conteudos_baixados' => $this->getConteudosMaisBaixados(),
            'conteudos_acessados' => $this->getConteudosMaisAcessados(),
            'conteudos_destaque' => $this->getConteudosDestaques(),
            'aplicativos_recentes' => $this->getAplicativosMaisRecentes(),
            'aplicativos_destaque' => $this->getAplicativosDestaques(),
        ];

        return response()->json($data, 200);
    }
    // CONTEÙDOS
    protected function getConteudosMaisRecentes()
    {
        $conteudos = Conteudo::orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return $conteudos->map(function ($conteudo) {
            return $conteudo->only(['id', 'title', 'image']);
        });
    }

    protected function getConteudosMaisBaixados()
    {
        $conteudos = Conteudo::orderBy('qt_downloads', 'desc')->limit(4)->get();

        return $conteudos->map(function ($conteudo) {
            return $conteudo->only(['id', 'title', 'image', 'qt_downloads']);
        });
    }
    protected function getConteudosMaisAcessados()
    {
        $conteudos = Conteudo::orderBy('qt_access', 'desc')->limit(4)->get();

        return $conteudos->map(function ($conteudo) {
            return $conteudo->only(['id', 'title', 'image', 'qt_access']);
        });
    }

    protected function getConteudosDestaques()
    {
        $conteudos = Conteudo::where("is_featured", true)->limit(4)->get();

        return $conteudos->map(function ($conteudo) {
            return $conteudo->only(['id', 'title', 'image']);
        });
    }
    // APLICATIVOS
    protected function getAplicativosDestaques()
    {
        $aplicativos = Aplicativo::whereRaw("options->'is_featured' = 'true'")
            ->limit(4)->get();

        return $aplicativos->map(function ($aplicativo) {
            return $aplicativo->only(['id', 'name', 'image']);
        });
    }
    protected function getAplicativosMaisRecentes()
    {
        $aplicativos = Aplicativo::orderBy('created_at', 'desc')->limit(4)->get();

        return $aplicativos->map(function ($aplicativo) {
            return $aplicativo->only(['id', 'name', 'image']);
        });
    }
}
