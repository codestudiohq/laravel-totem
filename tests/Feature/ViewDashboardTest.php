<?php

namespace Studio\Totem\Tests\Feature;

use Studio\Totem\Task;
use Studio\Totem\Result;
use Studio\Totem\Tests\TestCase;

class ViewDashboardTest extends TestCase
{
    /** @test */
    public function user_can_view_dashboard()
    {
        $this->signIn();
        $response = $this->get(route('totem.dashboard'));
        $response->assertStatus(302);
    }

    /** @test */
    public function guest_can_not_view_dashboard()
    {
        $response = $this->get(route('totem.dashboard'));
        $response->assertStatus(403);
    }

    /** @test */
    public function view_dashboard_single_task_no_results()
    {
        $this->signIn();
        $task = factory(Task::class)->create();
        $response = $this->get(route('totem.tasks.all', $task));
        $response->assertStatus(200);
        $this->assertEmpty($task->results);
        $this->assertSame(0.0, $task->averageRuntime);
        $response->assertSee($task->description);
    }

    /** @test */
    public function view_dashboard_single_task_with_results()
    {
        $this->signIn();
        $tasks = $this->_get_task_with_results();
        $response = $this->get(route('totem.tasks.all', $tasks[0]));
        $response->assertStatus(200);

        $this->assertNotEmpty($tasks[0]->results);
        $this->assertGreaterThanOrEqual(0.0, $tasks[0]->averageRuntime);
        $response->assertSee($tasks[0]->description);
    }

    /** @test */
    public function view_dashboard_single_task_with_multiple_results()
    {
        $this->signIn();
        $tasks = $this->_get_task_with_results(1, 9);
        $response = $this->get(route('totem.tasks.all', $tasks[0]));
        $response->assertStatus(200);

        $this->assertNotEmpty($tasks[0]->results);
        $this->assertGreaterThanOrEqual(0.0, $tasks[0]->averageRuntime);
        $response->assertSee($tasks[0]->description);
    }

    /** @test */
    public function view_dashboard_multiple_tasks_with_multiple_results()
    {
        $this->signIn();
        $tasks = $this->_get_task_with_results(4, 5);
        $response = $this->get(route('totem.tasks.all', $tasks[0]));
        $response->assertStatus(200);

        foreach ($tasks as $task) {
            $this->assertNotEmpty($task->results);
            $this->assertGreaterThanOrEqual(0.0, $task->averageRuntime);
            $response->assertSee($task->description);
        }
    }

    /**
     * @param int $task_count
     * @param int $result_count
     * @return mixed
     */
    private function _get_task_with_results($task_count = 1, $result_count = 1)
    {
        return factory(Task::class, $task_count)
            ->create()
            ->each(function ($task) use ($result_count) {
                for ($i = 0; $i < $result_count; $i++) {
                    $task->results()->save(factory(Result::class)->make());
                }
            });
    }
}
