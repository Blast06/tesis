<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use App\Models\Website;
use Symfony\Component\HttpFoundation\Response;

class ErrorsWebsiteValidationTest extends TestCase
{
    private $phone = "+1 (456) 565-4654";
    private $address = "La vega, Rep. Dominicana";

    /** @test */
    function users_can_see_validation_errors_form()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->json('POST',route('websites.store'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "address" => ["El campo direccion es obligatorio."],
                "name" => ["El campo sitio es obligatorio."],
                "phone" => ["El campo telefono es obligatorio."]
            ],
                "message" => "The given data was invalid.",
            ]);
    }

    /** @test */
    function users_cannot_register_duplicate_name()
    {
        $user = $this->createUser();

        $website = factory(Website::class)->create();

        $response = $this->actingAs($user)->json('POST',route('websites.store'), [
            'name' => $website->name,
            'phone' => $this->phone,
            'address' => $this->address
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "name" => ["El valor del campo sitio ya está en uso."]
            ],
                "message" => "The given data was invalid."
            ]);

        $this->assertDatabaseMissing('websites', [
            'name' => $website->name,
            'phone' => $this->phone,
            'address' => $this->address
        ]);
    }
}
