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
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('shaka-auth.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->singleton('shakaAuth', function ($app) {
        //    $instance = new ShakaRole();
        //    return $instance;
        //});

        $this->app->bind('ShakaAuth', function ($app) {
                    return new Entrust($app);
                });

        $this->app->alias('ShakaAuth', 'Cty\ShakaAuth\ShakaAuth');

        $this->mergeConfig();
    }

    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/config.php', 'shaka-auth'
        );
    }
}
