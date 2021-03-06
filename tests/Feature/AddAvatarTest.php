<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   function guest_cannot_change_avatar()
   {
       $this->withExceptionHandling();

       $this->json('POST', route('profiles.update'), [])
           ->assertStatus(Response::HTTP_UNAUTHORIZED);
   }

    /** @test */
    function an_user_can_change_avatar()
    {
        Storage::fake('public');

        $user = $this->create(User::class);

        $this->actingAs($user)
            ->json('POST', route('profiles.update'), [
                'avatar' => UploadedFile::fake()->image('avatar.jpg')
            ])
            ->assertSuccessful()
            ->assertExactJson(['message' => 'avatar actualizado correctamente.']);

        Storage::disk('public')->assertExists('1/avatar.jpg');
    }

    /** @test */
    function an_user_cannot_upload_others_file()
    {
        $this->handleValidationExceptions();

        $user = $this->create(User::class);

        Storage::fake($user->id);

        $this->actingAs($user)
            ->json('POST', route('profiles.update'), [
                'avatar' => UploadedFile::fake()->image('avatar.pdf')
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'errors' => ['avatar' => ['El campo avatar debe ser una imagen.']],
                'message' => 'The given data was invalid.'
            ]);
    }
}
