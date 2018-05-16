<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Website;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_subscribe_to_a_website()
    {
        $user = $this->createUser();

        $website = factory(Website::class)->create();

        $this->actingAs($user)
            ->json('POST',route('website.subscribe', $website))
            ->assertSuccessful()
            ->assertExactJson(['message' => 'subscribe']);

        $this->assertDatabaseHas('user_website', [
            'user_id' => $user->id,
            'website_id' =>$website->id
        ]);
    }

    /** @test */
    function user_can_unsubscribe_to_a_website()
    {
        $user = $this->createUser();

        $website = factory(Website::class)->create();

        $user->subscribeTo($website);

        $this->actingAs($user)
            ->json('POST',route('website.unsubscribe', $website))
            ->assertSuccessful()
            ->assertExactJson(['message' => 'unsubscribe']);

        $this->assertDatabaseMissing('user_website', [
            'user_id' => $user->id,
            'website_id' =>$website->id
        ]);
    }

    /** @test */
    function guest_cannot_subscribe_to_a_website()
    {
        $website = factory(Website::class)->create();

        $this->json('POST',route('website.subscribe', $website))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    function guest_cannot_unsubscribe_to_a_website()
    {
        $website = factory(Website::class)->create();

        $this->json('POST',route('website.unsubscribe', $website))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
