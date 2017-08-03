<?php

namespace Studio\Totem\Tests\Feature;

use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_basic_test()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
