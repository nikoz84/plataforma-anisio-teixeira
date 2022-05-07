<?php 

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException as KernelException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Traits\ApiResponser;

class Handler extends ExceptionHandler
{
    use ApiResponser;

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
     *
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof TokenExpiredException) {
            return $this->errorResponse([], 'Token expirado', 401);
        } elseif ($exception instanceof TokenInvalidException) {
            return $this->errorResponse([], 'Token inválido', 401);
        } elseif ($exception instanceof JWTException) {
            return $this->errorResponse([], 'Token não autorizado', 401);
        }
        
        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse([], "Erro em modelo", 404);
        }
        if ($exception instanceof QueryException) {
            return $this->errorResponse([], "Erro em query", 404);
        }
        
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse([], "Ação não autorizada, sem permissões", 403);
        }
        if ($exception instanceof HttpException) {
            return $this->errorResponse([], $exception->getMessage(), 404);
        }

        if ($exception instanceof KernelException) {
            return $this->errorResponse([], $exception->getMessage(), 500);
        }
        if ($exception instanceof ValidationException) {
            return $this->errorResponse([], 'Erro de validação', 500);
        }
        
        


        return parent::render($request, $exception);
    }
}