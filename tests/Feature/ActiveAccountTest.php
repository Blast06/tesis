<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActiveAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_active_account()
    {
        $user = factory(User::class)->create([
            'token' => User::generateToken(),
            'verified_at' => null
        ]);

        $url = URL::temporarySignedRoute(
            'account.activate', now()->addMinutes(30), ['token' => $user->token]
        );

        $this->get($url)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home')
            ->assertSessionHas(['flash_success' => '¡Tu cuenta ahora está confirmada!']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'token' => null,
            'verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $this->assertAuthenticated();
    }

    /** @test */
    function user_cannot_active_account_with_expired_token()
    {
        $user = factory(User::class)->create([
            'token' => User::generateToken(),
            'verified_at' => null
        ]);

        $url = URL::temporarySignedRoute(
            'account.activate', now()->addMinutes(30), ['token' => $user->token]
        );

        Carbon::setTestNow(Carbon::parse('+31 minutes'));

        $this->get($url)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home')
            ->assertSessionHas(['flash_danger' => 'Token desconocido']);

        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    function the_token_is_case_sensitive()
    {
        $user = factory(User::class)->create([
            'token' => User::generateToken(),
            'verified_at' => null
        ]);

        $url = URL::temporarySignedRoute(
            'account.activate', now()->addMinutes(30), ['token' => strtolower($user->token)]
        );

        $this->get($url)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertSee('Parece que has alterado el delicado equilibrio interno de mi ama de llaves.');

        $this->assertFalse($this->isAuthenticated());
    }

}
