<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ViewLog
{
    /**
     * Handle an incoming request.
     * Função ou método que lida uma solicitação de entrada
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    
        if($request->has('pass') && env('LOG_PASS') == $request->pass){
            return $next($request);
        }

        return redirect('/');
    }
}
