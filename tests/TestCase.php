<?php

namespace Studio\Totem\Tests;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Collective\Html\HtmlServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Orchestra\Testbench\Exceptions\Handler;
use Studio\Totem\Providers\TotemServiceProvider;
use Studio\Totem\Totem;
use Studio\Totem\User;
use Throwable;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);

        $this->artisan('totem:assets');

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $auth = function () {
            switch (app()->environment()) {
                case 'local':
                    return true;

                    break;
                case 'testing':
                    return Auth::check();

                    break;
                default:
                    return false;
            }
        };

        Totem::auth($auth);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form' => FormFacade::class,
            'Html' => HtmlFacade::class,
        ];
    }

    protected function getPackageProviders($app)
    {
        return [
            TotemServiceProvider::class,
            HtmlServiceProvider::class,
        ];
    }

    /**
     * Disable Exception Handling.
     */
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class() extends Handler
        {
            public function __construct()
            {
            }

            public function report(Throwable $e)
            {
            }

            public function render($request, Throwable $e)
            {
                throw $e;
            }
        });

        return $this;
    }

    /**
     * Creates and signs in a user.
     *
     * @return $this
     */
    public function signIn()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        return $this;
    }
}
