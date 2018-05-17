<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Website;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToWebsiteTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $website;

    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->website = factory(Website::class)->create();
    }

    /** @test */
    function user_can_subscribe_to_a_website()
    {
        $this->actingAs($this->user)
            ->json('POST',route('website.subscribe', $this->website))
            ->assertSuccessful()
            ->assertExactJson(['message' => 'subscribe']);

        $this->assertDatabaseHas('user_website', [
            'user_id' => $this->user->id,
            'website_id' =>$this->website->id
        ]);
    }

    /** @test */
    function user_can_unsubscribe_to_a_website()
    {
        $this->user->subscribeTo($this->website);

        $this->actingAs($this->user)
            ->json('POST',route('website.unsubscribe', $this->website))
            ->assertSuccessful()
            ->assertExactJson(['message' => 'unsubscribe']);

        $this->assertDatabaseMissing('user_website', [
            'user_id' => $this->user->id,
            'website_id' =>$this->website->id
        ]);
    }

    /** @test */
    function guest_cannot_subscribe_to_a_website()
    {
        $this->json('POST',route('website.subscribe', $this->website))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    function guest_cannot_unsubscribe_to_a_website()
    {
        $this->json('POST',route('website.unsubscribe', $this->website))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
