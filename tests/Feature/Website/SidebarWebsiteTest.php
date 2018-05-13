<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use App\Models\Website;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SidebarWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_see_sidebar_website_list()
    {
        $user = $this->createUser();

        $website1 = factory(Website::class)->create(['user_id' => $user->id]);
        $website2 = factory(Website::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)->get('/home')
            ->assertViewIs('pages.home')
            ->assertSee('Sitios De Trabajo')
            ->assertSee($website1->name)
            ->assertSee($website2->name);

    }

    /** @test */
    function guest_cannot_see_sidebar_website_list()
    {
        $user = $this->createUser();

        factory(Website::class)->create(['user_id' => $user->id]);
        factory(Website::class)->create(['user_id' => $user->id]);

        $this->get('/home')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');

    }
}
