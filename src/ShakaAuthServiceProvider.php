<?php

namespace Cty\ShakaAuth;

use Illuminate\Support\ServiceProvider;

class ShakaAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('shakaAuth', function ($app) {

            $instance = new ShakaRole();

            return $instance;
        });
    }
}
