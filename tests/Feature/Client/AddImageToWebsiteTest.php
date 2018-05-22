<?php

namespace Tests\Feature\Client;

use App\User;
use App\Website;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddImageToWebsiteTest extends TestCase
{
    use RefreshDatabase;

    private $website;

    protected function setUp()
    {
        parent::setUp();

        $this->website = factory(Website::class)->create();
    }

    /** @test */
    function guest_cannot_change_website_image()
    {
        $this->withExceptionHandling();

        $this->post(route('website.image', $this->website),[])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function client_can_change_website_image()
    {
        Storage::fake($this->website->user->id);

        $this->actingAs($this->website->user)
            ->post(route('website.image', $this->website),[
                'image' => UploadedFile::fake()->image('image.jpeg')
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['message' => 'imagen actualizada correctamente.']);
    }

    /** @test */
    function unathorized_user_cannot_change_website_image()
    {
        $this->actingAs($this->create(User::class))
            ->post(route('website.image', $this->website),[])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

    /** @test */
    function client_cannot_upload_others_file()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->website->user)
            ->json('POST',route('website.image', $this->website),[
                'image' => UploadedFile::fake()->image('image.pdf')
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'errors' => ['image' => ['El campo imagen del sitio debe ser una imagen.']],
                'message' => 'The given data was invalid.'
            ]);
    }
}