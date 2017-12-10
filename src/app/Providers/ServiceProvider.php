<?php

namespace Neji0924\Porm\Providers;

use Neji0924\Porm\Porm;
use Illuminate\Support\ServiceProvider as baseServiceProvider;

class ServiceProvider extends baseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
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
