<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{User, Website};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SidebarWebsiteTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->create(User::class);
    }

    /** @test */
    function an_user_can_see_sidebar_website_list()
    {
        $websites = $this->create(Website::class, ['user_id' => $this->user->id], 2);

        $this->actingAs($this->user)->get('/home')
            ->assertViewIs('pages.home')
            ->assertSee('Sitios De Trabajo')
            ->assertSee($websites[0]->name)
            ->assertSee($websites[1]->name);
    }

    /** @test */
    function a_guest_cannot_see_sidebar_website_list()
    {
        $this->withExceptionHandling();

        $this->create(Website::class, ['user_id' => $this->user->id], 2);

        $this->get('/home')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }
}
