<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use App\Conteudo;
use Gate;
use App\Canal;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    // protected $policies = [
    //     Aplicativo::class => AplicativoPolicy::class
    // ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('super-admin', function ( $user, $controller ) {
            return $user->is('super-admin');
        });
        Gate::define('update', function ($user, $controller) {
            return $user->id === $controller->user_id;
        });
        Gate::define('delete', function ($user, $controller) {
            return $user->id === $controller->user_id;
        });
    }
    // canais - usuarios ok - funcoes ok - linceças
}
