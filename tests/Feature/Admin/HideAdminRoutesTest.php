<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class HideAdminRoutesTest extends TestCase
{
    /** @test */
    function it_does_not_allow_guests_to_discover_admin_urls()
    {
        $this->withExceptionHandling();

        $this->get('admin/invalid-url')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('login');
    }

    /** @test */
    function it_does_not_allow_guests_to_discover_admin_urls_using_post()
    {
        $this->withExceptionHandling();

        $this->post('admin/invalid-url')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('login');
    }

    /** @test */
    function it_displays_404_when_admin_visit_invalid_urls()
    {
        $this->withExceptionHandling();

        $admin = $this->createAdmin();
        $this->actingAs($admin)
            ->get('admin/invalid-url')
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
