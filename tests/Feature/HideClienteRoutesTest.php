<?php

namespace Tests\Feature;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class HideClienteRoutesTest extends TestCase
{
    /** @test */
    function it_does_not_allow_guests_to_discover_client_urls()
    {
        $this->get('client/invalid-url')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('login');
    }

    /** @test */
    function it_does_not_allow_guests_to_discover_client_urls_using_post()
    {
        $this->post('client/invalid-url')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('login');
    }

    /** @test */
    function it_displays_404_when_client_visit_invalid_urls()
    {
        $user = $this->createUser();
        $this->actingAs($user)
            ->get('client/invalid-url')
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
