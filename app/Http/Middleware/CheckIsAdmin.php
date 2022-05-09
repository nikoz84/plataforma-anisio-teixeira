<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;

class CheckIsAdmin
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *Função que lida com a solcitação de entrada
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role->name == 'admin') {
            return $next($request);
        } else {
            return $this->errorResponse([], 'Não autorizado', 403);
        }
        return $next($request);
    }
}
