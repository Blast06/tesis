<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_search_any_registered_site()
    {
        $user = $this->createUser();

        $website1 = factory(Website::class)->create(['user_id' => $user->id]);
        $website2 = factory(Website::class)->create();

        $this->actingAs($user)->get('/websites')
            ->assertViewIs('pages.website')
            ->assertViewHas('websites', function($websites) use ($website1, $website2) {
                return $websites->contains($website1) && $websites->contains($website2);
            })
            ->assertSee($website1->name)
            ->assertSee($website2->name);

    }

    /** @test */
    function guests_can_search_any_registered_site()
    {
        $website1 = factory(Website::class)->create();
        $website2 = factory(Website::class)->create();

        $this->get('/websites')
            ->assertViewIs('pages.website')
            ->assertViewHas('websites', function($websites) use ($website1, $website2) {
                return $websites->contains($website1) && $websites->contains($website2);
            })
            ->assertSee($website1->name)
            ->assertSee($website2->name);

    }

    /** @test */
    function authenticated_users_can_see_a_specific_site()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $website = factory(Website::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)->get("/{$website->username}")
            ->assertViewIs('client.website.public')
            ->assertSee($website->name);

    }

    /** @test */
    function it_show_message_it_not_search_any_website()
    {
        $this->get('/websites')
            ->assertViewIs('pages.website')
            ->assertSee('No hay resultados...');
    }

}
