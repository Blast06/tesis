<?php

namespace Tests\Feature;

use App\User;
use App\Website;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateWebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => "Software Cristian",
        'username' => "big_system"
    ];

    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->create(User::class);
    }

    /** @test */
    function an_users_can_create_websites_and_is_subscribe_to()
    {
        $this->actingAs($this->user)
            ->json('POST',route('websites.store'), $this->withData())
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $this->withData()]);

        $this->assertDatabaseHas('websites', $this->withData());

        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->user->id,
            'favorites_type' => "App\\Website",
            'favorites_id' => $this->user->subscribedWebsite[0]->id,
        ]);
    }

    /** @test */
    function a_guests_cannot_create_websites()
    {
        $this->withExceptionHandling();

        $this->json('POST',route('websites.store'), [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('websites', $this->withData());
    }

    /** @test */
    function a_users_can_see_validation_errors_form()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)->json('POST',route('websites.store'), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "name" => ["El campo sitio es obligatorio."],
                "username" => ["El campo usuario es obligatorio."],
            ],
                "message" => "The given data was invalid.",
            ]);

        $this->assertDatabaseEmpty('websites');
    }

    /** @test */
    function a_users_cannot_register_duplicate_username()
    {
        $this->handleValidationExceptions();

        $this->create(Website::class, $this->withData());

        $this->actingAs($this->user)->json('POST',route('websites.store'), $this->withData([
            'name' => 'Big System inc.'
        ]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "username" => ["El valor del campo usuario ya está en uso."]
            ],
                "message" => "The given data was invalid."
            ]);

        $this->assertDatabaseMissing('websites', $this->withData(['name' => 'Big System inc.']));
    }

}
