<?php

namespace Studio\Totem\Tests\Feature;

use Studio\Totem\Tests\TestCase;

class CreateTaskTest extends TestCase
{
    /** @test */
    public function user_can_view_create_task_form()
    {
        $this->disableExceptionHandling()->signIn();

        $response = $this->get(route('totem.task.create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_not_view_create_task_form()
    {
        $response = $this->get(route('totem.task.create'));

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_create_task_with_cron_expression()
    {
        $this->disableExceptionHandling()->signIn();

        $response = $this->post(route('totem.task.create'), [
            'description'   => 'List All Scheduled Commands',
            'command'       => 'Studio\Totem\Console\Commands\ListSchedule',
            'type'          => 'cron',
            'cron'          => '* * * * *',
        ]);

        $response->assertRedirect(route('totem.tasks.all'));
    }

    /** @test */
    public function user_can_create_task_with_frequencies()
    {
        $this->disableExceptionHandling()->signIn();

        $response = $this->post(route('totem.task.create'), [
            'description'   => 'List All Scheduled Commands',
            'command'       => 'Studio\Totem\Console\Commands\ListSchedule',
            'type'          => 'frequency',
            'frequencies'   => [
                [
                    'interval'   => 'dailyAt',
                    'label'      => 'Daily',
                    'parameters' => [
                        [
                            'name'  => 'at',
                            'value' => '22:30',
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertRedirect(route('totem.tasks.all'));
    }
}
