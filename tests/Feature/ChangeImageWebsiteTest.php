<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Website;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangeImageWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_cannot_change_website_image()
    {
        $website = factory(Website::class)->create();

        $this->post(route('client.change.image', $website),[])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function client_can_change_website_image()
    {
        $website = factory(Website::class)->create();

        Storage::fake($website->user->id);

        $this->actingAs($website->user)
            ->post(route('client.change.image', $website),[
                'image' => UploadedFile::fake()->image('image.jpeg')
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['message' => 'imagen actualizada correctamente.']);
    }

    /** @test */
    function unathorized_user_cannot_change_website_image()
    {
        $website = factory(Website::class)->create();

        $this->actingAs($this->createUser())
            ->post(route('client.change.image', $website),[])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

    /** @test */
    function client_cannot_upload_others_file()
    {
        $website = factory(Website::class)->create();

        $this->actingAs($website->user)
            ->json('POST',route('client.change.image', $website),[
                'image' => UploadedFile::fake()->image('image.pdf')
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'errors' => ['image' => ['El campo imagen del sitio debe ser una imagen.']],
                'message' => 'The given data was invalid.'
            ]);
    }
}
