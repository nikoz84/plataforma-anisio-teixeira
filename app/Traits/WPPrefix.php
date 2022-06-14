<?php

namespace App\Traits;

trait  WPPrefix
{
    public function getPrefix()
    {
        return config('database.connections.mysql.extra_prefix');
    }
}
