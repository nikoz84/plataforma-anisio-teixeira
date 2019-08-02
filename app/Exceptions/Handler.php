<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof TokenExpiredException) {
            return Response::json(['message' => 'token_expired' . $exception->getMessage()], 201);
        } elseif ($exception instanceof TokenInvalidException) {
            return Response::json(['message' => 'token_invalid'], 201);
        } elseif ($exception instanceof JWTException) {
            //return Response::json(['message' => $exception->getMessage()], 201);
        }
        if ($exception instanceof ModelNotFoundException) {
            return Response::json(['message' => 'modelo não encontrado'], 201);
        }
        /*
        if ($exception instanceof HttpException) {
            return Response::json(
                [
                    'success' => false,
                    'message' => 'Muitas tentativas...'
                ],
                $exception->getStatusCode(),
                $exception->getHeaders()
            );
        }
        */

        return parent::render($request, $exception);
    }
}
