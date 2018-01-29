<?php

namespace Studio\Totem\Tests\Feature;

use Studio\Totem\Task;
use Studio\Totem\Tests\TestCase;

class CompileParametersTest extends TestCase
{
    public function test_no_paramters()
    {
        $task = factory(Task::class)->create();
        $parameters = $task->compileParameters();

        $this->assertEmpty($parameters);
    }

    public function test_multiple_paramters()
    {
        $task = factory(Task::class)->create();
        $task->parameters = '--parameter-1=value --parameter-2=value --parameter-3=value';
        $parameters = $task->compileParameters();

        $this->assertCount(3, $parameters);
        $this->assertEquals('value', $parameters['--parameter-1']);
        $this->assertEquals('value', $parameters['--parameter-2']);
        $this->assertEquals('value', $parameters['--parameter-3']);
    }

    public function test_flag_and_paramter()
    {
        $task = factory(Task::class)->create();
        $task->parameters = '--parameter-1=value --dry-run';
        $parameters = $task->compileParameters();

        $this->assertCount(2, $parameters);
        $this->assertArrayHasKey('--dry-run', $parameters);
        $this->assertTrue($parameters['--dry-run']);
        $this->assertEquals('value', $parameters['--parameter-1']);
    }

    public function test_multiple_flags()
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

    public function test_multiple_arguments()
    {
        $task = factory(Task::class)->create();
        $task->parameters = 'arg1 arg2 arg3';
        $parameters = $task->compileParameters();

        $this->assertCount(3, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('arg2', $parameters[1]);
        $this->assertSame('arg3', $parameters[2]);
    }

    public function test_multiple_named_arguments()
    {
        $task = factory(Task::class)->create();
        $task->parameters = 'arg1=name arg2=airport arg3=100';
        $parameters = $task->compileParameters();

        $this->assertCount(3, $parameters);
        $this->assertSame('name', $parameters['arg1']);
        $this->assertSame('airport', $parameters['arg2']);
        $this->assertSame('100', $parameters['arg3']);
    }

    public function test_multiple_mixed_arguments()
    {
        $task = factory(Task::class)->create();
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
        $task = factory(Task::class)->create();
        $task->parameters = 'arg1 arg2=test arg3=15 arg4 --flag --flag2 --option=yes --someplace=warm';
        $parameters = $task->compileParameters();

        $this->assertCount(8, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('test', $parameters['arg2']);
        $this->assertSame('15', $parameters['arg3']);
        $this->assertSame('arg4', $parameters[1]);
        $this->assertSame('warm', $parameters['--someplace']);
        $this->assertArrayHasKey('--flag', $parameters);
        $this->assertSame(true, $parameters['--flag']);
        $this->assertSame(true, $parameters['--flag2']);
    }

    public function test_all_mixed_arguments_console()
    {
        $task = factory(Task::class)->create();
        $task->parameters = 'arg1 arg2=test arg3=15 arg4 --flag --flag2 --option=yes --someplace=warm';
        $parameters = $task->compileParameters(true);

        $this->assertCount(8, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('test', $parameters[1]);
        $this->assertSame('15', $parameters[2]);
        $this->assertSame('arg4', $parameters[3]);
        $this->assertSame('--flag', $parameters[4]);
        $this->assertSame('--flag2', $parameters[5]);
        $this->assertSame('--option=yes', $parameters[6]);
        $this->assertSame('--someplace=warm', $parameters[7]);
    }

    public function test_array_arguments()
    {
        $task = factory(Task::class)->create();
        $task->parameters = 'arg1 arg2 arg3=test3.1 arg3=test3.2 --arg4=test4.1 --arg4=test4.2 --arg5=test5 --arg6';
        $parameters = $task->compileParameters();

        $this->assertCount(6, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('arg2', $parameters[1]);
        $this->assertSame(['test3.1', 'test3.2'], $parameters['arg3']);
        $this->assertSame(['test4.1', 'test4.2'], $parameters['--arg4']);
        $this->assertSame('test5', $parameters['--arg5']);
        $this->assertSame(true, $parameters['--arg6']);
    }

    public function test_array_arguments_console()
    {
        $task = factory(Task::class)->create();
        $task->parameters = 'arg1 arg2 arg3=test3.1 arg3=test3.2 --arg4=test4.1 --arg4=test4.2 --arg5=test5 --arg6';
        $parameters = $task->compileParameters(true);
        
        $this->assertCount(8, $parameters);
        $this->assertSame('arg1', $parameters[0]);
        $this->assertSame('arg2', $parameters[1]);
        $this->assertSame('test3.1', $parameters[2]);
        $this->assertSame('test3.2', $parameters[3]);
        $this->assertSame('--arg4=test4.1', $parameters[4]);
        $this->assertSame('--arg4=test4.2', $parameters[5]);
        $this->assertSame('--arg5=test5', $parameters[6]);
        $this->assertSame('--arg6', $parameters[7]);
    }

    public function test_positional_quoted_arguments()
    {
        $task = factory(Task::class)->create();
        $task->parameters = '"test" \'123\' "test=123" \'test = 123\'';
        $parameters = $task->compileParameters();

        $this->assertCount(4, $parameters);
        $this->assertSame('"test"', $parameters[0]);
        $this->assertSame('\'123\'', $parameters[1]);
        $this->assertSame('"test=123"', $parameters[2]);
        $this->assertSame('\'test = 123\'', $parameters[3]);
    }

    public function test_named_quoted_arguments()
    {
        $task = factory(Task::class)->create();
        $task->parameters = 'arg1="test" --arg2=\'123\' arg3="test=123" --arg4=\'test = 123\'';
        $parameters = $task->compileParameters();

        $this->assertCount(4, $parameters);
        $this->assertSame('"test"', $parameters['arg1']);
        $this->assertSame('\'123\'', $parameters['--arg2']);
        $this->assertSame('"test=123"', $parameters['arg3']);
        $this->assertSame('\'test = 123\'', $parameters['--arg4']);
    }
}
