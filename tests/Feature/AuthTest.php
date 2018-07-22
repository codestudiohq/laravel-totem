<?php

namespace Studio\Totem\Tests\Feature;

use Studio\Totem\Totem;
use Illuminate\Http\Request;
use Studio\Totem\Tests\TestCase;
use Studio\Totem\Http\Middleware\Authenticate;

class AuthTest extends TestCase
{
    /** @test */
    public function auth_callback_works()
    {
        $request = new Request();
        $request->replace(['user' => 'roshan']);
        $this->assertFalse(Totem::check($request));

        Totem::auth(function (Request $request) {
            return $request->input('user') === 'roshan';
        });

        $this->assertTrue(Totem::check($request));
        $request->replace(['user' => 'taylor']);
        $this->assertFalse(Totem::check($request));
        $request = new Request();
        $this->assertFalse(Totem::check($request));
    }

    /** @test */
    public function auth_middleware_works()
    {
        Totem::auth(function () {
            return true;
        });

        $middleware = new Authenticate;

        $response = $middleware->handle(
            new Request,
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
            new Request,
            function ($value) {
                return 'response';
            }
        );
    }
}
