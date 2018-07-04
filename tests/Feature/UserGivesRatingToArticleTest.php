<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{User, Article, Review};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGivesRatingToArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
      'rating' => 4,
      'comment' => 'Me gusta este articulo'
    ];

    private $user;

    private $article;

    private $review;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->create(User::class);
        $this->article = $this->create(Article::class);
        $this->review = $this->create(Review::class);
    }

    /** @test */
    function a_guest_cannot_rating_article()
    {
        $this->withExceptionHandling();
        
        $this->post(route('articles.reviews.store', $this->article), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('reviews', $this->withData());
    }

    /** @test */
    function a_guest_cannot_modify_rating_article()
    {
        $this->withExceptionHandling();

        $this->put(route('articles.reviews.update', [
            'article' => $this->review->article,
            'review' => $this->review
        ]), $this->withData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('reviews', $this->withData());
    }

    /** @test */
    function user_can_rating_article()
    {
        $this->actingAs($this->user)
            ->post(route('articles.reviews.store', $this->article), $this->withData())
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('reviews', $this->withData());
    }

    /** @test */
    function user_can_modify_rating_article()
    {
        $this->actingAs($this->review->user)
             ->put(route('articles.reviews.update', [
                 'article' => $this->review->article,
                 'review' => $this->review
             ]), $this->withData())
            ->assertOk();

        $this->assertDatabaseHas('reviews', $this->withData());
    }

    /** @test */
    function user_only_rating_once_per_article()
    {
        $this->withExceptionHandling();

        $this->be($this->user);

        $this->post(route('articles.reviews.store', $this->article), $this->withData())
            ->assertStatus(Response::HTTP_CREATED);

        $this->post(route('articles.reviews.store', $this->article), $this->withData([
            'rating' => 1,
            'comment' => 'No me gusto este articulo'
        ]))->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertCount(1, collect($this->user->reviews));
    }

    /** @test */
    function user_cannot_modify_others_rating_article()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->put(route('articles.reviews.update', [
                'article' => $this->review->article,
                'review' => $this->review
            ]), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('reviews', $this->withData());
    }

    /** @test */
    function user_owner_of_the_article_cannot_rating_it()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->article->website->user)
            ->post(route('articles.reviews.store', $this->article), $this->withData())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('reviews', $this->withData());
    }

}
