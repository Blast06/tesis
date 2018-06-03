<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResendActiveCodeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_forwarded_activation_code_account()
    {
        Notification::fake();

        $user = $this->create(User::class, [
            'verified_at' => null
        ]);

        $this->actingAs($user)
            ->post(route('activate.resend.code'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => 'Se a reenviado el enlace de activación, por favor revisa tu correo electrónico.']);

        $user->refresh();

        $this->assertTrue(
            $user->token !== null
        );
    }

    /** @test */
    function guest_cannot_forwarded_activation_code_account()
    {
        $this->withExceptionHandling();

        $this->post(route('activate.resend.code'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function user_with_active_account_cannot_forwarded_activation_code_account()
    {
        $this->actingAs($this->create(User::class))
            ->post(route('activate.resend.code'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

}
