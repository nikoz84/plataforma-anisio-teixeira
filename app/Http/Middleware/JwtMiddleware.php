<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

// use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware extends BaseMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'success'=> false,
                    'message'=> 'Token Inválido',
                    'status' => 'invalid_token_md'
                 ]);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'success'=> false,
                    'message'=> 'Token Expirado',
                    'status' => 'expired_token_md']);
            } else {
                return response()->json([
                    'success'=> false,
                    'message' => 'Token de autorização não encontrado',
                    'status' => 'token_not_found_md'
                ]);
            }
        }
        return $next($request);
        
    }
}
