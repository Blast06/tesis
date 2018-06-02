<?php

namespace Tests\Feature\Client;

use App\User;
use App\Website;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Website
     */
    private $website;

    protected function setUp()
    {
        parent::setUp();
        $this->website = factory(Website::class)->create();
    }

    /** @test */
    function a_guest_cannot_update_website()
    {
        $this->withExceptionHandling();

        $this->put($this->website->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function a_client_can_update_website()
    {
        $this->actingAs($this->website->user)
            ->put($this->website->url->update, [
                'name' => 'New name website'
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['data' => true]);

        $this->assertDatabaseHas('websites', [
            'name' => 'New name website'
        ]);

    }

    /** @test */
    function an_unathorized_user_cannot_update_website()
    {
        $this->actingAs($this->create(User::class))
            ->put($this->website->url->update, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

}
