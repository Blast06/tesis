<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\{Article, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'nuevo articulo',
        'price' => 500,
        'stock' => 10,
        'status' => Article::STATUS_AVAILABLE,
        'description' => 'descripcion del articulo es bastante larga'
    ];

    /** @test */
    function a_client_can_update_owns_articles()
    {

        $article = $this->create(Article::class);

        $this->actingAs($article->website->user)
            ->json('put', $article->url->update, $this->withData([
                'sub_category_id' => $article->sub_category_id
            ]))
            ->assertSuccessful();

        $this->assertDatabaseHas('articles', $this->withData([
            'sub_category_id' => $article->sub_category_id
        ]));
    }

    /** @test */
    function a_client_cannot_update_articles_from_others_client()
    {
        $articles = $this->create(Article::class, [], 2);

        $this->actingAs($articles[0]->website->user)
            ->json('put', $articles[1]->url->update, $this->withData([
                'sub_category_id' => $articles[1]->sub_category_id
            ]))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');

        $this->assertDatabaseMissing('articles', $this->withData());
    }

    /** @test */
    function a_non_clients_cannot_update_articles()
    {
        $article = $this->create(Article::class);

        $this->actingAs($this->create(User::class))
            ->json('put', $article->url->update, $this->withData([
                'sub_category_id' => $article->sub_category_id
            ]))
            ->assertStatus( Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

    /** @test */
    function a_client_can_see_validation_errors_form()
    {
        $this->handleValidationExceptions();

        $article = $this->create(Article::class);

        $this->actingAs($article->website->user)
            ->json('put', $article->url->update, [])
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
    }
}
