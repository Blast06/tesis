<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdministratorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_see_dashboard()
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('admin.dashboard')
            ->assertSee("Dashboard Administrador");
    }

    /** @test */
    function a_guest_cannot_see_admin_dashboard()
    {
        $this->withExceptionHandling();

        $this->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function an_unauthorized_user_cannot_see_admin_dashboard()
    {
        $this->withExceptionHandling();

        $admin = $this->create(User::class);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
