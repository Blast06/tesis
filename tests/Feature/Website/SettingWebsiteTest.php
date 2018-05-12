<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use App\Models\Website;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function client_can_change_website_image()
    {
        $this->withoutExceptionHandling();

        Storage::fake('avatars');

        $website = factory(Website::class)->create();

        $this->actingAs($website->user)
            ->post(route('client.change.image', $website),[
                'image' => UploadedFile::fake()->image('image.jpeg')
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['message' => 'imagen actualizada correctamente.']);
    }

}
