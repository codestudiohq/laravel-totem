<?php

namespace Studio\Totem\Tests\Feature;

use App\User;
use Tests\TestCase;
use Studio\Totem\Totem;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CanCreateTask extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authorized_user_can_view_create_task_form()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('totem.task.create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function unauthorized_user_can_not_view_create_task_form()
    {
        $response = $this->get(route('totem.task.create'));

        $response->assertStatus(403);
    }
}
