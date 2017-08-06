<?php

namespace Studio\Totem\Tests\Feature;

use Tests\TestCase;
use Studio\Totem\Totem;
use Studio\Totem\Http\Middleware\Authenticate;

class AuthTest extends TestCase
{
    /** @test */
    public function auth_callback_works()
    {
        $this->assertFalse(Totem::check('roshan'));

        Totem::auth(function ($request) {
            return $request === 'roshan';
        });

        $this->assertTrue(Totem::check('roshan'));
        $this->assertFalse(Totem::check('taylor'));
        $this->assertFalse(Totem::check(null));
    }

    /** @test */
    public function auth_middleware_works()
    {
        Totem::auth(function () {
            return true;
        });

        $middleware = new Authenticate;

        $response = $middleware->handle(
            new class {
            },
            function ($value) {
                return 'response';
            }
        );

        $this->assertEquals('response', $response);
    }

    /**
     * @test
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function auth_middleware_responds_with_403_on_failure()
    {
        Totem::auth(function () {
            return false;
        });

        $middleware = new Authenticate;

        $response = $middleware->handle(
            new class {
            },
            function ($value) {
                return 'response';
            }
        );
    }
}
