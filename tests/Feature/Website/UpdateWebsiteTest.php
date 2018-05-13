<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use App\Models\Website;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_cannot_update_website()
    {
        $website = factory(Website::class)->create();

        $this->put(route('client.setting.update', $website),[])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function client_can_update_website()
    {
        $website = factory(Website::class)->create();

        $this->actingAs($website->user)
            ->put(route('client.setting.update', $website),[
                'name' => 'New name website'
            ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success']);

        $this->assertDatabaseHas('websites', [
            'name' => 'New name website'
        ]);

    }

    /** @test */
    function unathorized_user_cannot_update_website()
    {
        $website = factory(Website::class)->create();

        $this->actingAs($this->createUser())
            ->put(route('client.setting.update', $website),[])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

}
