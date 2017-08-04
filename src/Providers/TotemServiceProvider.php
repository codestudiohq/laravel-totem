<?php

namespace Studio\Totem\Providers;

use Illuminate\Support\ServiceProvider;

class TotemServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResources();
    }

    /**
     * Register any services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('TOTEM_PATH')) {
            define('TOTEM_PATH', realpath(__DIR__.'/../../'));
        }
    }

    /**
     * Register the Totem resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'totem');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            HORIZON_PATH.'/public/js' => public_path('vendor/horizon/js'),
        ], 'horizon-assets');

        $this->publishes([
            HORIZON_PATH.'/public/css' => public_path('vendor/horizon/css'),
        ], 'horizon-assets');

        $this->publishes([
            HORIZON_PATH.'/public/img' => public_path('vendor/horizon/img'),
        ], 'horizon-assets');
    }
}
