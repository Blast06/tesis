<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use App\Models\Website;
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
            ->post(route('website.subscribe', $website))
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
            ->post(route('website.unsubscribe', $website))
            ->assertSuccessful()
            ->assertExactJson(['message' => 'unsubscribe']);

        $this->assertDatabaseMissing('user_website', [
            'user_id' => $user->id,
            'website_id' =>$website->id
        ]);
    }

    /** @test */
    function guest_cannot_unsubscribe_to_a_website()
    {
        $website = factory(Website::class)->create();

        $this->post(route('website.unsubscribe', $website))
            ->assertRedirect('/login');
    }
}
