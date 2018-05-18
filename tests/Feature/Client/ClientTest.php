<?php

namespace Tests\Feature\Client;

use App\Website;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function client_can_access_the_client_section()
    {
        $website = factory(Website::class)->create();

        $this->actingAs($website->user)
            ->get(route('client.dashboard', $website))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('client.dashboard')
            ->assertSee("Dashboard {$website->name}");
    }

    /** @test */
    function unauthorized_user_cannot_access_the_client_section()
    {
        $website = factory(Website::class)->create();

        $admin = $this->createUser();

        $this->actingAs($admin)
            ->get(route('client.dashboard', $website))
            ->assertStatus(Response::HTTP_FOUND);
    }

    /** @test */
    function guest_cannot_see_client_dashboard()
    {
        $website = factory(Website::class)->create();

        $this->get(route('client.dashboard', $website))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }
}
