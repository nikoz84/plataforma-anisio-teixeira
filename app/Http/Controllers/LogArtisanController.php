<?php
namespace App\Http\Controllers;

use App\Helpers\LogArtsanFileReader;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LogArtisanController extends ApiController{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //$this->middleware('jwt.auth');
        $this->request = $request;
    }

    function index(Request $request)
    {
        $logArtsanFileReader = new LogArtsanFileReader();
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 15);
        $logArtsanFileReader->readLogFile($limit, $limit*($page-1));
        $paginator = new LengthAwarePaginator( array_map(function($log){
            if($log !== null)
            return json_decode($log->toJson());
        },$logArtsanFileReader->getLogArtisanObjects()),$logArtsanFileReader->total(), $limit, $page, [
            "path"=>"logartisan"
        ]);
        return  $this->showAsPaginator($paginator);
    }

    function search()
    {
        
    }
}