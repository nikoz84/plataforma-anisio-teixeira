<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Traits\ApiResponser;

class JwtMiddleware extends BaseMiddleware
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->errorResponse([], "Token Inválido", 401);
            } elseif ($e instanceof TokenExpiredException) {
                return $this->errorResponse([], "Token Expirado", 403);
            } else {
                return $this->errorResponse([], 'Erro desconhecido', 403);
            }
        }
        return $next($request);
    }
}
