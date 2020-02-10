<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\AplicativoPolicy;
use App\Policies\ConteudoPolicy;
use App\Policies\CanalPolicy;
use App\Aplicativo;
use App\Canal;
use App\Conteudo;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Aplicativo::class => AplicativoPolicy::class,
        Canal::class => CanalPolicy::class,
        Conteudo::class => ConteudoPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
