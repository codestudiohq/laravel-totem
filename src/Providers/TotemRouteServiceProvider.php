<?php

namespace Studio\Totem\Providers;

use Studio\Totem\Task;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class TotemRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Studio\Totem\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Route::model('task', Task::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'prefix' => config('totem.uri', 'totem'),
            'namespace' => $this->namespace,
            'middleware' => config('totem.web.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'prefix' => config('totem.uri', 'totem').'/'.config('totem.api_prefix', 'api'),
            'namespace' => $this->namespace,
            'middleware' => config('totem.api.middleware', 'api'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        });
    }
}
