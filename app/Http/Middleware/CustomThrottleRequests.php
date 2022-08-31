<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomThrottleRequests extends ThrottleRequests
{
    use ApiResponser;

    /**
     * Função Protegida que constroi uma exceção
     *
     * @param  mixed  $key
     * @param  mixed  $maxAttempts
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
