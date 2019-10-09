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

        Gate::define('super-admin', function ($user, $x) {
            return $user->is('super-admin');
        });
        Gate::define('update', function ($user, $controller) {
            // return $user->id == $controller->user_id or $user->role_id == 1;
            return $user->id == $controller->user_id
            or $user->role_id == 1
            or $user->role_id == 2;
        });
        Gate::define('delete', function ($user, $controller) {
            return $user->id == $controller->user_id
            or $user->role_id == 2
            or $user->role_id == 1;
        });
    }
}
