<?php
namespace App\Http\Controllers;

use App\Helpers\LogArtsanFileReader;
use App\LogArtisan as AppLogArtisan;
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
        $artisanLog = new AppLogArtisan();
        $logArtsanFileReader = new LogArtsanFileReader();
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 15);
        $logArtsanFileReader->readLogFile($limit, $limit*($page-1));
        $artisanLog->setMessage("erro aem lugar");
        $paginator = new LengthAwarePaginator( array_map(function($log){
            return json_decode($log->toJson());
        },$logArtsanFileReader->getLogArtisanObjects()), $limit, $page);
        return  $this->showAsPaginator($paginator);
    }
}