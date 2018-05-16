<?php

namespace Tests\Feature;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_create_websites()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->json('POST',"v1/websites", $this->getData());

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $this->getData()]);

        $this->assertDatabaseHas('websites', $this->getData());

        // Suscribed to website
        $this->assertDatabaseHas('user_website', [
            'user_id' => $user->id,
            'website_id' => (\App\Models\Website::first())->id
        ]);
    }

    /** @test */
    function guests_cannot_create_websites()
    {
        $response = $this->json('POST','v1/websites', []);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('websites', $this->getData());
    }

    protected function getData()
    {
        return [
            'name' => "Software Cristian",
            'username' => "big_system"
        ];
    }

}
