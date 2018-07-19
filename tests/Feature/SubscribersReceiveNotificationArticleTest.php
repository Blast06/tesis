<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\{Notifications\NewArticleNotification, User, Website, Article, SubCategory};

class SubscribersReceiveNotificationArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'nuevo articulo',
        'price' => 500,
        'stock' => 10,
        'status' => Article::STATUS_AVAILABLE,
        'description' => 'descripcion del articulo es bastante larga',
    ];

    /** @test */
    function an_subscribers_receive_a_notification_when_an_article_is_created()
    {
        Notification::fake();

        $users = $this->create(User::class, [], 3);
        $website = $this->create(Website::class);

        foreach ($users as $user) {
            $user->subscribeTo($website);
        }

        $this->actingAs($website->user)
            ->json('POST',route('client.articles.store', $website), $this->withData([
                'website_id' => $website->id,
                'sub_category_id' => ($this->create(SubCategory::class))->id,
            ]))
            ->assertStatus(Response::HTTP_CREATED);

        Notification::assertSentTo(
            [$users], NewArticleNotification::class
        );
    }

    /** @test */
    function an_client_not_receive_a_notification_when_he_create_article()
    {
        Notification::fake();

        $website = $this->create(Website::class);

        $website->user->subscribeTo($website);

        $this->actingAs($website->user)
            ->json('POST',route('client.articles.store', $website), $this->withData([
                'website_id' => $website->id,
                'sub_category_id' => ($this->create(SubCategory::class))->id,
            ]))
            ->assertStatus(Response::HTTP_CREATED);

        Notification::assertNotSentTo(
            [$website->user], NewArticleNotification::class
        );
    }
}
