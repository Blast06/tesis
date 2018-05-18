<?php

namespace Tests\Feature;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateWebsiteTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    /** @test */
    function an_users_can_create_websites_and_is_subscribe_to()
    {
        $this->actingAs($this->user)
            ->json('POST',route('websites.store'), $this->getData())
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $this->getData()]);

        $this->assertDatabaseHas('websites', $this->getData());

        $this->assertDatabaseHas('user_website', [
            'user_id' => $this->user->id,
            'website_id' => (\App\Website::first())->id
        ]);
    }

    /** @test */
    function a_guests_cannot_create_websites()
    {
        $this->json('POST',route('websites.store'), [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('websites', $this->getData());
    }

    /** @test */
    function a_users_can_see_validation_errors_form()
    {
        $this->actingAs($this->user)->json('POST',route('websites.store'), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "name" => ["El campo sitio es obligatorio."],
                "username" => ["El campo usuario es obligatorio."],
            ],
                "message" => "The given data was invalid.",
            ]);
    }

    /** @test */
    function a_users_cannot_register_duplicate_username()
    {
        factory(\App\Website::class)->create($this->getData());

        $this->actingAs($this->user)->json('POST',route('websites.store'), $this->getData([
            'name' => 'Big System inc.'
        ]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "username" => ["El valor del campo usuario ya está en uso."]
            ],
                "message" => "The given data was invalid."
            ]);

        $this->assertDatabaseMissing('websites', $this->getData(['name' => 'Big System inc.']));
    }

    protected function getData($data = [])
    {
        return array_filter(array_merge([
            'name' => "Software Cristian",
            'username' => "big_system"
        ],$data));
    }

}
