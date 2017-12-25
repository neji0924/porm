<?php

namespace Neji0924\Porm\Providers;

use Neji0924\Porm\Porm;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(
            __DIR__ . '/../../resources/views/porm',
            'porm'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('porm', function() {
            return new Porm;
        });
    }
}
