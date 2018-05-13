<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarChangeTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   function guest_cannot_change_avatar()
   {
       $this->post('profile/change/avatar',[])
           ->assertStatus(Response::HTTP_FOUND)
           ->assertRedirect('/login');
   }

    /** @test */
    function authenticated_user_can_change_avatar()
    {
        $user = $this->createUser();

        Storage::fake($user->id);

        $this->actingAs($user)
            ->post('profile/change/avatar',[
                'avatar' => UploadedFile::fake()->image('avatar.jpg')
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['message' => 'avatar actualizada correctamente.']);
    }

    /** @test */
    function authenticated_user_cannot_upload_others_file()
    {
        $user = $this->createUser();

        Storage::fake($user->id);

        $this->actingAs($user)
            ->json('POST','profile/change/avatar',[
                'avatar' => UploadedFile::fake()->image('avatar.pdf')
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertExactJson([
                'errors' => ['avatar' => ['El campo avatar debe ser una imagen.']],
                'message' => 'The given data was invalid.'
            ]);
    }
}
