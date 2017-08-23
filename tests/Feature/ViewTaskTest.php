<?php

namespace Studio\Totem\Tests\Feature;

use Studio\Totem\Task;
use Studio\Totem\Tests\TestCase;

class ViewTaskTest extends TestCase
{
    /** @test */
    public function user_can_view_task()
    {
        $this->signIn();
        $task = factory(Task::class)->create();
        $response = $this->get(route('totem.task.view', $task));
        $response->assertStatus(200);
        $response->assertSee($task->description);
        $response->assertSee('Studio\Totem\Console\Commands\ListSchedule');
        $response->assertSee($task->expression);
    }

    /** @test */
    public function guest_can_not_view_task()
    {
        $task = factory(Task::class)->create();
        $response = $this->get(route('totem.task.view', $task));
        $response->assertStatus(403);
    }
}
