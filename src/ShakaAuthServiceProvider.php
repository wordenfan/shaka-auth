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
            __DIR__ . '/Config/config.php' => config_path('shaka-auth.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ShakaAuth', function ($app) {
                    return new ShakaAuthRole($app);
                });

        $this->app->alias('ShakaAuth', 'Cty\ShakaAuth\ShakaAuth');

        $this->mergeConfig();
    }

    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/config.php', 'shaka-auth'
        );
    }
}
