<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl
{   /**
     *Handle an incoming request.
     * Função que lida com a solicitação de entrada
    */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        //$response->header('Cache-Control', 'no-cache, must-revalidate');
        // Or whatever you want it to be:
        $response->header('Cache-Control', 'max-age=31536000');
        $response->header('Set-Cookie', 'HttpOnly;Secure;cross-site=teste;SameSite=None;');
        //setcookie('cross-site', 'teste', ['samesite' => 'None', 'secure' => true]);

        return $response;
    }
}
