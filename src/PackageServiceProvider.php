<?php

namespace Dyumna\Minify;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\JSMinify::class,
                Commands\CSSMinify::class,
                Commands\Build::class,
            ]);
        }

        $this->publishes([
            __DIR__ .'/../resources/config/minify.php' => config_path('minify.php'),
        ]);
    }
}
