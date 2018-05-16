<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Website;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ErrorsValidationWebsiteTest extends TestCase
{
    use RefreshDatabase;

    private $name = 'Big System';

    /** @test */
    function users_can_see_validation_errors_form()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->json('POST','v1/websites', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
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
        $user = $this->createUser();

        $website = factory(Website::class)->create();

        $response = $this->actingAs($user)->json('POST','v1/websites', [
            'name' => $this->name,
            'username' => $website->username
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "username" => ["El valor del campo usuario ya está en uso."]
            ],
                "message" => "The given data was invalid."
            ]);

        $this->assertDatabaseMissing('websites', [
            'name' => $this->name,
            'username' => $website->username
        ]);
    }
}
