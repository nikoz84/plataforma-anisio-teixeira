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
        $this->middleware('jwt.verify')->except(['index', 'getLayout']);
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
}
