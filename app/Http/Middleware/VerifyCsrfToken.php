<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * Os URIs que devem ser excluídos da verificação de CSRF.
     *
     * @var array
     */
    protected $except = [];
}
