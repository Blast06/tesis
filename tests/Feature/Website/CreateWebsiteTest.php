<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateWebsiteTest extends TestCase
{
    use RefreshDatabase;

    private $name = "Software Cristian";
    private $username = "big_system";

    /** @test */
    function users_can_create_websites()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->json('POST',route('websites.store'), [
            'name' => $this->name,
            'username' => $this->username,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => [
                'name' => $this->name,
                'username' => $this->username,
            ]]);

        $this->assertDatabaseHas('websites', [
            'name' => $this->name,
            'username' => $this->username
        ]);
    }

    /** @test */
    function guests_cannot_create_websites()
    {
        $response = $this->json('POST',route('websites.store'), []);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('websites', [
            'name' => $this->name,
            'username' => $this->username,
        ]);
    }

}
