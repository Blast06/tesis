<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\{User, Website};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddImageToWebsiteTest extends TestCase
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
    function a_guest_cannot_change_website_image()
    {
        $this->withExceptionHandling();

        $this->post($this->website->url->image ,[])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function a_client_can_change_website_image()
    {
        Storage::fake('public');

        $this->actingAs($this->website->user)
            ->post($this->website->url->image, [
                'image' => UploadedFile::fake()->image('image.png')
            ])
            ->assertSuccessful()
            ->assertExactJson(['message' => 'imagen actualizada correctamente.']);
    }

    /** @test */
    function an_unathorized_user_cannot_change_website_image()
    {
        $this->actingAs($this->create(User::class))
            ->post($this->website->url->image, [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

    /** @test */
    function a_client_cannot_upload_others_file()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->website->user)
            ->json('POST', $this->website->url->image, [
                'image' => UploadedFile::fake()->image('image.pdf')
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'errors' => ['image' => ['El campo imagen del sitio debe ser una imagen.']],
                'message' => 'The given data was invalid.'
            ]);
    }
}
