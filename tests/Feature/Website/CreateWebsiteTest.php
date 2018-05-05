<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateWebsiteTest extends TestCase
{
    private $name = "Software Cristian";
    private $phone = "+1 (456) 565-4654";
    private $address = "La vega, Rep. Dominicana";

    /** @test */
    function users_can_create_websites()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->json('POST',route('websites.store'), [
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => [
                'name' => $this->name
            ]]);

        $this->assertDatabaseHas('websites', [
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address
        ]);
    }

    /** @test */
    function guests_cannot_create_websites()
    {
        $response = $this->json('POST',route('websites.store'), []);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('websites', [
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address
        ]);
    }

}
