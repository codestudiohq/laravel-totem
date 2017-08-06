<?php

namespace Studio\Totem\Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Studio\Totem\Totem;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateTaskTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_create_task_form()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('totem.task.create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_not_view_create_task_form()
    {
        $response = $this->get(route('totem.task.create'));

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_create_task()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post(route('totem.task.create'),[
            'description'   => 'List All Scheduled Commands',
            'command'   =>  'Studio\Totem\Console\Commands\ListSchedule',
            'frequencies'   =>  [
                'task_frequency' => [
                    'frequency' => 'hourly'
                ]
            ]
        ]);

        $response->assertRedirect(route('totem.tasks.all'));
    }
}
