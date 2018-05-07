<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Website;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function client_can_see_dashboard()
    {
        $website = factory(Website::class)->create();

        $this->actingAs($website->user)
            ->get(route('client.dashboard', $website))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('client.dashboard')
            ->assertSee("Dashboard {$website->name}");
    }

    /** @test */
    function unauthorized_user_cannot_see_client_dashboard()
    {
        $website = factory(Website::class)->create();

        $admin = $this->createUser();

        $this->actingAs($admin)
            ->get(route('client.dashboard', $website))
            ->assertStatus(Response::HTTP_FOUND);
    }
}
