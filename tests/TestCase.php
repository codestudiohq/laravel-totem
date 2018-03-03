<?php

namespace Studio\Totem\Tests;

use Exception;
use Studio\Totem\User;
use Studio\Totem\Totem;
use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use Collective\Html\HtmlServiceProvider;
use Orchestra\Testbench\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Studio\Totem\Providers\TotemServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);

        $this->artisan('totem:assets');

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->withFactories(__DIR__.'/../database/factories/');

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
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(Exception $e)
            {
            }

            public function render($request, Exception $e)
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
        $user = factory(User::class)->create();

        $this->actingAs($user);

        return $this;
    }
}
