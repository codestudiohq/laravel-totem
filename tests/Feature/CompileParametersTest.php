<?php

namespace Studio\Totem\Tests\Feature;

use Studio\Totem\Task;
use Studio\Totem\Tests\TestCase;

class CompileParametersTest extends TestCase
{
    public function test_no_paramters()
    {
        $task = Task::factory()->create();
        $parameters = $task->compileParameters();

        $this->assertEmpty($parameters);
    }

    public function test_multiple_paramters()
    {
        $task = Task::factory()->create();
        $task->parameters = '--parameter-1=value --parameter-2=value --parameter-3=value';
        $parameters = $task->compileParameters();

        $this->assertCount(3, $parameters);
        $this->assertEquals('value', $parameters['--parameter-1']);
        $this->assertEquals('value', $parameters['--parameter-2']);
        $this->assertEquals('value', $parameters['--parameter-3']);
    }

    public function test_flag_and_paramter()
    {
        $task = Task::factory()->create();
        $task->parameters = '--parameter-1=value --dry-run';
        $parameters = $task->compileParameters();

        $this->assertCount(2, $parameters);
        $this->assertArrayHasKey('--dry-run', $parameters);
        $this->assertTrue($parameters['--dry-run']);
        $this->assertEquals('value', $parameters['--parameter-1']);
    }

    public function test_multiple_flags()
    {
        $task = Task::factory()->create();
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

    public function test_multiple_arguments()
    {
        $task = Task::factory()->create();
        $task->parameters = 'arg1 arg2 arg3';
        $parameters = $task->compileParameters();

        $this->assertCount(3, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('arg2', $parameters[1]);
        $this->assertSame('arg3', $parameters[2]);
    }

    public function test_multiple_named_arguments()
    {
        $task = Task::factory()->create();
        $task->parameters = 'arg1=name arg2=airport arg3=100';
        $parameters = $task->compileParameters();

        $this->assertCount(3, $parameters);
        $this->assertSame('name', $parameters['arg1']);
        $this->assertSame('airport', $parameters['arg2']);
        $this->assertSame('100', $parameters['arg3']);
    }

    public function test_multiple_mixed_arguments()
    {
        $task = Task::factory()->create();
        $task->parameters = 'arg1 arg2=test arg3=15 arg4';
        $parameters = $task->compileParameters();

        $this->assertCount(4, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('test', $parameters['arg2']);
        $this->assertSame('15', $parameters['arg3']);
        $this->assertSame('arg4', $parameters[1]);
    }

    public function test_all_mixed_arguments()
    {
        $task = Task::factory()->create();
        $task->parameters = 'arg1 arg2=test arg3=15 arg4 --flag --flag2 --option=yes --someplace=warm  --equals="a=1 and b=2"';
        $parameters = $task->compileParameters();

        $this->assertCount(9, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('test', $parameters['arg2']);
        $this->assertSame('15', $parameters['arg3']);
        $this->assertSame('arg4', $parameters[1]);
        $this->assertSame('warm', $parameters['--someplace']);
        $this->assertArrayHasKey('--flag', $parameters);
        $this->assertSame(true, $parameters['--flag']);
        $this->assertSame(true, $parameters['--flag2']);
        $this->assertSame('a=1 and b=2', $parameters['--equals']);
    }

    public function test_all_mixed_arguments_console()
    {
        $task = Task::factory()->create();
        $task->parameters = 'arg1 arg2=test arg3=15 arg4 --flag --flag2 --option=yes --someplace=warm';
        $parameters = $task->compileParameters(true);

        $this->assertCount(8, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('test', $parameters[1]);
        $this->assertSame('15', $parameters[2]);
        $this->assertSame('arg4', $parameters[3]);
        $this->assertSame('--flag', $parameters[4]);
        $this->assertSame('--flag2', $parameters[5]);
        $this->assertSame('yes', $parameters['--option']);
        $this->assertSame('warm', $parameters['--someplace']);
    }

    public function test_single_dash()
    {
        $task = Task::factory()->create();
        $task->parameters = '-osTeSt';
        $parameters = $task->compileParameters(true);

        $this->assertCount(1, $parameters);
        $this->assertSame('-osTeSt', $parameters[0]);
    }

    public function test_array_argument()
    {
        $task = Task::factory()->create();
        $task->parameters = '--id=1 --id=2';
        $parameters = $task->compileParameters(true);

        $this->assertCount(1, $parameters);
        $this->assertIsArray($parameters['--id']);
        $this->assertSame('1', $parameters['--id'][0]);
        $this->assertSame('2', $parameters['--id'][1]);
    }

    public function test_equals_value_not_breaks()
    {
        $task = Task::factory()->create();
        $task->parameters = 'arg1="a=b" --option="c=d" --option="a=1 and b=2"';
        $parameters = $task->compileParameters(true);

        $this->assertCount(2, $parameters);
        $this->assertSame('a=b', $parameters[0]);
        $this->assertSame('c=d', $parameters['--option'][0]);
        $this->assertSame('a=1 and b=2', $parameters['--option'][1]);
    }
}
