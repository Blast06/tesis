<?php

namespace Tests\Feature\Client;

use App\Website;
use Tests\TestCase;
use App\SubCategory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    private $subcategory;
    private $website;

    protected function setUp()
    {
        parent::setUp();

        $this->subcategory = factory(SubCategory::class)->create();

        $this->website = factory(Website::class)->create();
    }

    /** @test */
    function an_client_can_create_a_product()
    {
        $this->actingAs($this->website->user)
            ->post(route('products.store', $this->website), $this->getData())
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $this->getData()]);

        $this->assertDatabaseHas('products', $this->getData());
    }

    /** @test */
    function a_non_client_cannot_create_a_product()
    {
        $this->actingAs($this->createUser())
            ->post(route('products.store', $this->website), $this->getData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

    protected function getData($data = [])
    {
        return array_filter(array_merge([
            'name' => 'nuevo producto',
            'price' => 500.00,
            'website_id' => $this->website->id,
            'sub_category_id' => $this->subcategory->id,
            'description' => 'descripcion del producto es bastante larga'
        ],$data));
    }
}
