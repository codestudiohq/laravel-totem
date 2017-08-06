<?php

namespace Studio\Totem\Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewDashboardTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_totem_dashboard()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('totem.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_not_view_totem_dashboard()
    {
        $response = $this->get(route('totem.dashboard'));

        $response->assertStatus(403);
    }
}
