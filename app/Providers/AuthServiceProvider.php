<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Gate;
use App\Policies\AplicativoPolicy;
use App\Conteudo;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Conteudo::class => AplicativoPolicy::class
    ];

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
            // die($model->user_id . "---" . $user->id . "---" . $user->role_id) ;
            // $user->id == $model->user_id
            return $user->id == $controller->user_id;
        });
        Gate::define('delete', function ($user, $controller) {
            return $user->id === $controller->user_id;
        });
    }
    // canais - usuarios ok - funcoes ok - linceças
}
