<?php

namespace Studio\Totem\Tests\Feature;

use Studio\Totem\Task;
use Studio\Totem\Tests\TestCase;

class CompileParametersTest extends TestCase
{
    /** @test */
    public function no_paramters()
    {
        $task = factory(Task::class)->create();
        $parameters = $task->compileParameters();

        $this->assertEmpty($parameters);
    }

    /** @test */
    public function multiple_paramters()
    {
        $task = factory(Task::class)->create();
        $task->parameters = '--parameter-1=value --parameter-2=value --parameter-3=value';
        $parameters = $task->compileParameters();

        $this->assertCount(3, $parameters);
        $this->assertEquals('value', $parameters['--parameter-1']);
        $this->assertEquals('value', $parameters['--parameter-2']);
        $this->assertEquals('value', $parameters['--parameter-3']);
    }

    public function flag_and_paramter()
    {
        $task = factory(Task::class)->create();
        $task->parameters = '--parameter-1=value --dry-run';
        $parameters = $task->compileParameters();

        $this->assertCount(2, $parameters);
        $this->assertArrayHasKey('--dry-run', $parameters);
        $this->assertTrue($parameters['--dry-run']);
        $this->assertEquals('value', $parameters['--parameter-1']);
    }

    public function multiple_flags()
    {
        $task = factory(Task::class)->create();
        $task->parameters = '--dry-run --debug --log-output';
        $parameters = $task->compileParameters();

        $this->assertCount(3, $parameters);
        $this->assertArrayHasKey('--dry-run', $parameters);
        $this->assertArrayHasKey('--debug', $parameters);
        $this->assertArrayHasKey('--log-output', $parameters);
        $this->assertTrue($parameters['--dry-run']);
        $this->assertTrue($parameters['--debug']);
        $this->assertTrue($parameters['--log-output']);
    }
}
