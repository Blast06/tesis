<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_can_register()
    {
        $this->post('/register', $this->getValidData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');

        $this->assertAuthenticated();
    }

    /** @test */
    function guest_can_see_validation_erros()
    {
        $this->post('/register', [])
            ->assertSessionHasErrors(['name','email','password']);

        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    function its_email_must_be_unique()
    {
        $user = $this->createUser();

        $this->post('/register', $this->getValidData([
            'email' => $user->email
        ]))->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['email']);

        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    function its_can_upload_avatar()
    {
        Storage::fake('1');

        $this->post('/register', $this->getValidData([
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]))->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');

        $this->assertAuthenticated();
    }

    /** @test */
    function it_cannot_upload_others_file()
    {
        $this->post('/register',[
                'avatar' => UploadedFile::fake()->image('image.pdf')
            ])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['avatar' => 'El campo avatar debe ser una imagen.']);
    }

    protected function getValidData(array $custom = [])
    {
        return array_filter(array_merge([
            'name' => 'Cristian Gomez',
            'email' => 'cristiangomeze@example.com',
            'password' => 'L@ravel1',
            'password_confirmation' => 'L@ravel1',
        ], $custom));
    }
}
