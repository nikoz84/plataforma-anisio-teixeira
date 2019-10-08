<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role->name == 'super-admin') {
            return $next($request);
        } else {
            return $this->errorResponse([], 'Não autorizado', 403);
        }
        return $next($request);
    }
}
