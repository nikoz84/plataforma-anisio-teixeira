<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GoogleAnalytics;

class GoogleAnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('google_analytics', function () {
            return new GoogleAnalytics();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
