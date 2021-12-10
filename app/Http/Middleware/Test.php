<?php

namespace App\Http\Middleware;

use Closure;

class Test
{
    /**
     * Handle an incoming request.
     * Função ou método que lida com uma solicitação de entrada
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        session()->flash('test', 'text-key-from-middleware');
        return $next($request);
    }
}
