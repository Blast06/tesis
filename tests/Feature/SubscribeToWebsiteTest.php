<?php

namespace Tests\Feature;

use App\User;
use App\Website;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\Website
     */
    private $website;

    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->create(User::class);
        $this->website = $this->create(Website::class);
    }

    /** @test */
    function an_user_can_subscribe_to_a_website()
    {
        $this->actingAs($this->user)
            ->json('POST', $this->website->url->subscribe)
            ->assertSuccessful()
            ->assertExactJson(['message' => 'subscribe']);

        $this->assertDatabaseHas('user_website', [
            'user_id' => $this->user->id,
            'website_id' =>$this->website->id
        ]);
    }

    /** @test */
    function an_user_can_unsubscribe_to_a_website()
    {
        $this->user->subscribeTo($this->website);

        $this->actingAs($this->user)
            ->json('POST', $this->website->url->unsubscribe)
            ->assertSuccessful()
            ->assertExactJson(['message' => 'unsubscribe']);

        $this->assertDatabaseMissing('user_website', [
            'user_id' => $this->user->id,
            'website_id' =>$this->website->id
        ]);
    }

    /** @test */
    function a_guest_cannot_subscribe_to_a_website()
    {
        $this->withExceptionHandling();

        $this->json('POST', $this->website->url->subscribe)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    function a_guest_cannot_unsubscribe_to_a_website()
    {
        $this->withExceptionHandling();

        $this->json('POST', $this->website->url->unsubscribe)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
