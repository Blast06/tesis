<?php

namespace Tests\Feature\Register;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ActiveAccountTest extends TestCase
{
    /** @test */
    function user_can_active_account()
    {
        $user = factory(User::class)->create([
            'activation_code' => User::generateToken(),
            'verified_at' => null
        ]);

        $url = URL::temporarySignedRoute(
            'account.activate', now()->addMinutes(30), ['token' => $user->activation_code]
        );

        $this->get($url)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'activation_code' => null,
            'verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /** @test */
    function user_cannot_active_account_with_defeated_url()
    {
        $user = factory(User::class)->create([
            'activation_code' => User::generateToken(),
            'verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $url = URL::temporarySignedRoute(
            'account.activate', now()->addSeconds(1), ['token' => $user->activation_code]
        );

        $this->get($url)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertSee('Parece que has alterado el delicado equilibrio interno de mi ama de llaves.');
    }
}
