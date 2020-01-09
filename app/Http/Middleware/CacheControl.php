<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        //$response->header('Cache-Control', 'no-cache, must-revalidate');
        // Or whatever you want it to be:
        $response->header('Cache-Control', 'max-age=31536000');

        return $response;
    }
}
