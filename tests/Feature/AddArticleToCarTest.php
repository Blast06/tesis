<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{Article, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddArticleToCarTest extends TestCase
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
   function an_user_can_add_to_shopping_car_any_article()
   {
       $this->actingAs($this->user)
           ->json('GET', route('articles.add.car', [
               $this->article,
               1
           ]))
           ->assertSuccessful()
           ->assertExactJson(['message' => "Article {$this->article->name} add to shopping car"]);

       $this->assertDatabaseHas('shopping_car', [
           'quantity' => 1,
           'article_id' => $this->article->id,
           'user_id' => $this->user->id
       ]);
   }

    /** @test */
    function an_user_add_the_same_article_this_updated_in_shopping_car()
    {
        $this->user->addArticleToCar($this->article, 1);

        $this->actingAs($this->user)
            ->json('GET', route('articles.add.car', [
                $this->article,
                5
            ]))
            ->assertSuccessful()
            ->assertExactJson(['message' => "Article {$this->article->name} add to shopping car"]);

        $this->assertDatabaseHas('shopping_car', [
            'quantity' => 5,
            'article_id' => $this->article->id,
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    function an_user_can_remove_to_shopping_car_any_article()
    {
        $this->user->addArticleToCar($this->article, 1);

        $this->actingAs($this->user)
            ->json('GET', route('articles.remove.car', [$this->article]))
            ->assertSuccessful()
            ->assertExactJson(['message' => "Article {$this->article->name} remove to shopping car"]);

        $this->assertDatabaseMissing('shopping_car', [
            'quantity' => 1,
            'article_id' => $this->article->id,
            'user_id' => $this->user->id
        ]);
    }
}
