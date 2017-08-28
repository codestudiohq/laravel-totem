<?php

namespace Studio\Totem\Providers;

use Cron\CronExpression;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Studio\Totem\Contracts\TaskInterface;
use Studio\Totem\Console\Commands\ListSchedule;
use Studio\Totem\Console\Commands\PublishAssets;
use Studio\Totem\Repositories\EloquentTaskRepository;

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
        $this->defineAssetPublishing();

        Validator::extend('cron_expression', function ($attribute, $value, $parameters, $validator) {
            return CronExpression::isValidExpression($value);
        });
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

        $this->commands([
            ListSchedule::class,
            PublishAssets::class,
        ]);

        $this->app->bindIf('totem.tasks', EloquentTaskRepository::class, true);
        $this->app->alias('totem.tasks', TaskInterface::class);
        $this->app->register(TotemRouteServiceProvider::class);
        $this->app->register(TotemEventServiceProvider::class);

        if (Schema::hasTable('tasks')) {
            $this->app->register(ConsoleServiceProvider::class);
        }

        $this->mergeConfigFrom(
            __DIR__.'/../../config/totem.php',
            'totem'
        );
    }

    /**
     * Register the Totem resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'totem');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'totem');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            TOTEM_PATH.'/public/js' => public_path('vendor/totem/js'),
        ], 'totem-assets');

        $this->publishes([
            TOTEM_PATH.'/public/css' => public_path('vendor/totem/css'),
        ], 'totem-assets');

        $this->publishes([
            TOTEM_PATH.'/public/img' => public_path('vendor/totem/img'),
        ], 'totem-assets');
    }
}
