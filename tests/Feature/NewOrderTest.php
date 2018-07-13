<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{Article, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewOrderTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $articles;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->create(User::class);
        $this->articles = $this->create(Article::class, [], 2);
    }

    /** @test */
    function guest_cannot_order_articles()
    {
        $this->withExceptionHandling();

        $this->post(route('orders.store'), [])
            ->assertStatus(Response::HTTP_FOUND);
    }

    /** @test */
    function user_can_many_orders_articles()
    {
        $this->actingAs($this->user)
            ->post(route('orders.store'), [
                'orders' => [
                    [
                        'article_id' => $this->articles[0]->id,
                        'quantity' => 1,
                    ],
                    [
                        'article_id' => $this->articles[1]->id,
                        'quantity' => 2,
                    ],
                ]
            ])->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('orders', [
            'article_id' => $this->articles[0]->id,
            'website_id' =>  $this->articles[0]->website->id,
            'quantity' => 1,
            'status' => \App\Order::STATUS_WAIT
        ]);

        $this->assertDatabaseHas('orders', [
            'article_id' => $this->articles[1]->id,
            'website_id' =>  $this->articles[1]->website->id,
            'quantity' => 2,
            'status' => \App\Order::STATUS_WAIT
        ]);
    }

    /** @test */
    function a_stock_of_the_article_is_reduced_when_new_orders_is_registered_and_this_stock_is_not_null()
    {
        $article = $this->create(Article::class, [
            'stock' => 10
        ]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'stock' => $article->stock
        ]);

        $this->actingAs($this->user)
            ->post(route('orders.store'), [
                'orders' => [
                    [
                        'article_id' => $article->id,
                        'quantity' => 10,
                    ]
                ]
            ])->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'stock' => 0
        ]);

    }

    /** @test */
    function an_order_price_set_null_if_article_price_its_private()
    {
        $article = $this->create(Article::class, [
            'status' => Article::STATUS_PRIVATE
        ]);

        $this->actingAs($this->user)
            ->post(route('orders.store'), [
                'orders' => [
                    [
                        'article_id' => $article->id,
                        'quantity' => 1,
                    ]
                ]
            ])->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('orders', [
            'price' => null,
            'article_id' => $article->id
        ]);
    }

    /** @test */
    function an_article_change_status_when_stock_is_out()
    {
        $article = $this->create(Article::class, [
            'stock' => 10
        ]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => Article::STATUS_AVAILABLE
        ]);

        $this->actingAs($this->user)
            ->post(route('orders.store'), [
                'orders' => [
                    [
                        'article_id' => $article->id,
                        'quantity' => 10,
                    ]
                ]
            ])->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => Article::STATUS_NOT_AVAILABLE
        ]);

    }

    /** @test */
    function it_see_errors_in_order_processing()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user)
            ->post(route('orders.store'), [
                'orders' => [
                    [
                        'article_id' => $this->articles[1]->id,
                        'stock' => 2,
                    ],
                ]
            ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    function it_see_show_errors_is_article_not_not_available()
    {
        $this->withExceptionHandling();

        $article = $this->create(Article::class, [
            'status' => Article::STATUS_NOT_AVAILABLE
        ]);

        $this->actingAs($this->user)
            ->post(route('orders.store'), [
                'orders' => [
                    [
                        'article_id' => $article->id,
                        'quantity' => 10,
                    ]
                ]
            ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    function it_see_show_errors_is_article_stock_is_less_tan_order_quantity()
    {
        $this->withExceptionHandling();

        $article = $this->create(Article::class, [
            'stock' => 5
        ]);

        $this->actingAs($this->user)
            ->post(route('orders.store'), [
                'orders' => [
                    [
                        'article_id' => $article->id,
                        'quantity' => 10,
                    ]
                ]
            ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
