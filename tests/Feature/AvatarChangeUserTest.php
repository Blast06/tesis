<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarChangeUserTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   function guest_cannot_change_avatar()
   {
       $this->json('POST', route('profiles.avatar'), [])
           ->assertStatus(Response::HTTP_UNAUTHORIZED);
   }

    /** @test */
    function authenticated_user_can_change_avatar()
    {
        $user = $this->createUser();

        Storage::fake($user->id);

        $this->actingAs($user)
            ->json('POST', route('profiles.avatar'), [
                'avatar' => UploadedFile::fake()->image('avatar.jpg')
            ])
            ->assertSuccessful()
            ->assertExactJson(['message' => 'avatar actualizado correctamente.']);
    }

    /** @test */
    function authenticated_user_cannot_upload_others_file()
    {
        $user = $this->createUser();

        Storage::fake($user->id);

        $this->actingAs($user)
            ->json('POST', route('profiles.avatar'), [
                'avatar' => UploadedFile::fake()->image('avatar.pdf')
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'errors' => ['avatar' => ['El campo avatar debe ser una imagen.']],
                'message' => 'The given data was invalid.'
            ]);
    }
}
