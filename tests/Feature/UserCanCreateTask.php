<?php

namespace Studio\Totem\Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanCreateTask extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_create_schedule_form()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('totem.task.create'));

        $response->assertStatus(200);
    }
}
