<?php

namespace Tests\Feature\Client;

use App\User;
use App\Website;
use Tests\TestCase;
use App\SubCategory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'nuevo producto',
        'price' => 500,
        'description' => 'descripcion del producto es bastante larga'
    ];
    private $subcategory;
    private $website;

    protected function setUp()
    {
        parent::setUp();

        $this->subcategory = $this->create(SubCategory::class);
        $this->website = $this->create(Website::class);
    }

    /** @test */
    function a_non_client_cannot_create_a_product()
    {
        $this->actingAs($this->create(User::class))
            ->post(route('products.store', $this->website), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

    /** @test */
    function an_client_can_create_a_product()
    {
        $this->actingAs($this->website->user)
            ->json('POST',route('products.store', $this->website), $this->withData([
                'website_id' => $this->website->id,
                'sub_category_id' => $this->subcategory->id,
            ]))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $this->withData([
                'website_id' => $this->website->id,
                'sub_category_id' => $this->subcategory->id,
            ])]);

        $this->assertDatabaseHas('products', $this->withData([
            'website_id' => $this->website->id,
            'sub_category_id' => $this->subcategory->id,
        ]));
    }

    /** @test */
    function an_client_can_create_a_product_and_make_it_private()
    {
        $this->actingAs($this->website->user)
            ->post(route('products.store', $this->website), $this->withData([
                'price' => null,
                'website_id' => $this->website->id,
                'sub_category_id' => $this->subcategory->id,
            ]))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $this->withData([
                'price' => null,
                'website_id' => $this->website->id,
                'sub_category_id' => $this->subcategory->id,
            ])]);

        $this->assertDatabaseHas('products', $this->withData([
            'price' => null,
            'website_id' => $this->website->id,
            'sub_category_id' => $this->subcategory->id,
        ]));
    }

}
