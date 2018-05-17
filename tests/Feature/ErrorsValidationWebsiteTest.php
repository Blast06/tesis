<?php

namespace Tests\Feature;

use App\Website;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ErrorsValidationWebsiteTest extends TestCase
{
    use RefreshDatabase;

    private $name = 'Big System';
    private $user;
    private $website;

    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->website = factory(Website::class)->create();
    }

    /** @test */
    function users_can_see_validation_errors_form()
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
    function users_cannot_register_duplicate_username()
    {
        $this->actingAs($this->user)->json('POST',route('websites.store'), [
            'name' => $this->name,
            'username' => $this->website->username
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "username" => ["El valor del campo usuario ya está en uso."]
            ],
                "message" => "The given data was invalid."
            ]);

        $this->assertDatabaseMissing('websites', [
            'name' => $this->name,
            'username' => $this->website->username
        ]);
    }
}
