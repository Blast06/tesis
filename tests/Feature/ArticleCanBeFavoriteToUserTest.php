<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{Article, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleCanBeFavoriteToUserTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $article;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->create(User::class);
        $this->article = $this->create(Article::class);
    }

    /** @test */
    function an_article_can_be_favorite_to_user()
    {
        $this->actingAs($this->user)
            ->json('GET', $this->article->url->favorite)
            ->assertSuccessful()
            ->assertExactJson(['message' => "Article {$this->article->name} is now favorited"]);

        $this->assertDatabaseHas('favorites', [
            'favorites_type' => "App\\Article",
            'favorites_id' => $this->article->id,
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    /** @test */
    function an_article_can_be_unfavorite_to_user()
    {
        $this->user->favoriteTo($this->article);

        $this->actingAs($this->user)
            ->json('GET', $this->article->url->unfavorite)
            ->assertSuccessful()
            ->assertExactJson(['message' => "Article {$this->article->name} is now unfavorited"]);

        $this->assertDatabaseMissing('favorites', [
            'favorites_type' => "App\\Article",
            'favorites_id' => $this->article->id,
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    function an_article_cannot_be_favorite_to_guest()
    {
        $this->withExceptionHandling();

        $this->json('GET', $this->article->url->unfavorite)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    function an_article_cannot_be_unfavorite_to_guest()
    {
        $this->withExceptionHandling();

        $this->json('GET', $this->article->url->unfavorite)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
