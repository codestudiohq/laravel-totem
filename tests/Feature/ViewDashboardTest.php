<?php

namespace Studio\Totem\Tests\Feature;

use Tests\TestCase;

class ViewDashboardTest extends TestCase
{
    /** @test */
    public function user_can_view_totem_dashboard()
    {
        $response = $this->signIn()->get(route('totem.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_not_view_totem_dashboard()
    {
        $response = $this->get(route('totem.dashboard'));

        $response->assertStatus(403);
    }
}
