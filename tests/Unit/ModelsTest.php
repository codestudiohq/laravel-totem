<?php

namespace Studio\Totem\Tests\Unit;

use Studio\Totem\Task;
use Studio\Totem\Result;
use Studio\Totem\Frequency;
use Studio\Totem\Parameter;
use Studio\Totem\Tests\TestCase;

class ModelsTest extends TestCase
{
    /** @test */
    public function it_uses_table_prefix_from_the_config()
    {
        config(['totem.table_prefix' => 'prefixed_']);

        $this->assertEquals('prefixed_tasks', (new Task)->getTable());
        $this->assertEquals('prefixed_task_results', (new Result)->getTable());
        $this->assertEquals('prefixed_task_frequencies', (new Frequency)->getTable());
        $this->assertEquals('prefixed_frequency_parameters', (new Parameter)->getTable());
    }
}
