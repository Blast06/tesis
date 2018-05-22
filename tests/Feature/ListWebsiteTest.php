<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{User, Website};
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_search_any_registered_site()
    {
        $user = $this->create(User::class);

        $website1 = $this->create(Website::class, ['user_id' => $user->id]);
        $website2 =  $this->create(Website::class);

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
        $websites_list = $this->create(Website::class, [], 2);

        $this->get('/websites')
            ->assertViewIs('pages.website')
            ->assertViewHas('websites', function($websites) use ($websites_list) {
                return $websites->contains($websites_list[0]) && $websites->contains($websites_list[0]);
            })
            ->assertSee($websites_list[0]->name)
            ->assertSee($websites_list[1]->name);
    }

    /** @test */
    function authenticated_users_can_see_a_specific_site()
    {
        $user = $this->create(User::class);

        $website = $this->create(Website::class, ['user_id' => $user->id]);

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
