<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use App\{User, Website, Article, SubCategory};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'nuevo articulo',
        'price' => 500,
        'stock' => 10,
        'status' => Article::STATUS_AVAILABLE,
        'description' => 'descripcion del articulo es bastante larga'
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
    function a_non_client_cannot_create_a_article()
    {
        $this->actingAs($this->create(User::class))
            ->post(route('articles.store', $this->website), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

    /** @test */
    function a_client_can_create_a_article()
    {
        Notification::fake();

        $this->actingAs($this->website->user)
            ->json('POST',route('articles.store', $this->website), $this->withData([
                'website_id' => $this->website->id,
                'sub_category_id' => $this->subcategory->id,
            ]))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $this->withData([
                'website_id' => $this->website->id,
                'sub_category_id' => $this->subcategory->id,
            ])]);

        $this->assertDatabaseHas('articles', $this->withData([
            'website_id' => $this->website->id,
            'sub_category_id' => $this->subcategory->id,
        ]));
    }

    /** @test */
    function a_client_can_see_validation_errors_form()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->website->user)
            ->json('POST',route('articles.store', $this->website), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson(["errors" => [
                "name" => ["El campo titulo es obligatorio."],
                "price" => ["El campo precio es obligatorio."],
                "status" => ["El campo estado es obligatorio."],
                "description" => ["El campo descripcion es obligatorio."],
                "sub_category_id" => ["El campo categoria es obligatorio."],
            ],
                "message" => "The given data was invalid.",
            ]);

        $this->assertDatabaseEmpty('articles');
    }
}
