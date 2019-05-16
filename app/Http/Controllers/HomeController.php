<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verify')->except(['index', 'getLinks']);
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
    public function getLinks()
    {
        $links = DB::select('select name, slug from canais where is_active = ? order by id asc', [true]);

        return response()->json([
            'links' => $links,
        ]);
    }
}
