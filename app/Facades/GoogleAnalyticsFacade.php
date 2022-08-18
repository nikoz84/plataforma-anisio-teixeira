<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleAnalyticsFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'google_analytics';
    }
}
