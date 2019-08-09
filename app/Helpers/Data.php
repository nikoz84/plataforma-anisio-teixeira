<?php

namespace App\Helpers;

use Carbon\Carbon;

class Data
{
    protected $carbon;

    public function __construct(Carbon $carbon)
    {
        $this->carbon = new $carbon;
    }

    public function getFormatedData(){
        $this->carbon
    }
}
