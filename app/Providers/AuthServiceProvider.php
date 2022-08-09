<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\Aplicativo::class => \App\Policies\AplicativoPolicy::class,
        \App\Models\Canal::class => \App\Policies\CanalPolicy::class,
        \App\Models\Conteudo::class => \App\Policies\ConteudoPolicy::class,
        \App\Models\Document::class => \App\Policies\DocumentPolicy::class,
        \App\Models\PlayList::class => \App\Policies\PlayListPolicy::class,
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
