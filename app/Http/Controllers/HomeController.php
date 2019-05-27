<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Options;

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
    public function getHomeData(){
        $data = [
            'conteudos_recentes'=> $this->getConteudosMaisRecentes(),
            'conteudos_baixados' => $this->getMaisBaixados(),
            'conteudos_acessados' => $this->getMaisAcessados(),
            'conteudos_destaque' => $this->getAplicativosDestaques(),
            'aplicativos_recentes' => $this->getAplicativosMaisRecentes(), 
            'aplicativos_destaque' => $this->getAplicativosDestaques(),
        ];

        return response()->json($data,200);
    }
    protected function getConteudosMaisRecentes(){
        
        $mais_recentes = DB::select('SELECT id, title 
                                    from conteudos 
                                    order by created_at desc  
                                    limit 4');
        
        return $mais_recentes;
    }
    protected function getAplicativosMaisRecentes(){
        
        $mais_recentes = DB::select('SELECT id, name 
                                    from aplicativos 
                                    order by created_at desc
                                    limit 4');
        
        return $mais_recentes;
    }
    protected function getMaisBaixados(){
        $mais_baixados = DB::select('SELECT id, title, qt_downloads 
                                    from conteudos 
                                    order by qt_downloads desc
                                    limit 4');
        
        return $mais_baixados;
    }
    protected function getMaisAcessados(){
        $mais_acessados = DB::select('SELECT id, title, qt_access 
                                    from conteudos 
                                    order by qt_access desc
                                    limit 4
                                    ');
        
        return $mais_acessados;
    }
    protected function getAplicativosDestaques(){
        $destaques = DB::select(DB::raw("SELECT id, name 
                                    from aplicativos 
                                    where options->>'is_featured' = 'true'
                                    limit 4"));
        
        return $destaques;
    }
    protected function getConteudosDestaques(){
        $destaques = DB::select(DB::raw("SELECT id, title 
                                        from conteudos 
                                        where is_featured = true
                                        limit 4"));
        
        return $destaques;
    }
    
}
