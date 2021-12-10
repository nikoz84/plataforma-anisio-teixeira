<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;
use App\Traits\ApiResponser;

class CustomThrottleRequests extends ThrottleRequests
{
    use ApiResponser;
    /**
     * Função Protegida que constroi uma exceção
     * @param mixed $key
     * @param mixed $maxAttempts
     * 
     * @return void
     */

    protected function buildException($key, $maxAttempts)
    {
        $retryAfter = $this->getTimeUntilNextRetry($key);

        $headers = $this->getHeaders(
            $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );

        //return $this->errorResponse([], 'Muitas requisições', 429, $headers);
    }
}
