<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admin_can_see_dashboard()
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('admin.dashboard')
            ->assertSee("Admin Dashboard");
    }

    /** @test */
    function unauthorized_user_cannot_see_admin_dashboard()
    {
        $admin = $this->createUser();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
