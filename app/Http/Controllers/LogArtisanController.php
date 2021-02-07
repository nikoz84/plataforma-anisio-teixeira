<?php
namespace App\Http\Controllers;

use App\Helpers\LogArtsanFileReader;
use App\LogArtisan as AppLogArtisan;
use LogArtisan;

class LogArtisanController extends ApiController{

    function index()
    {
        $artisanLog = new AppLogArtisan();
        $logArtsanFileReader = new LogArtsanFileReader();
        $logArtsanFileReader->readLogFile(10, 0);
        $artisanLog->setMessage("erro aem lugar");
        return  $logArtsanFileReader->getLogArtisanObjectsJson();
    }
}