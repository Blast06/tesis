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
            ->post(route('account.activation.resend'), [])
            ->assertStatus(Response::HTTP_FOUND);

        $user->refresh();

        $this->assertTrue(
            $user->token !== null
        );
    }

    /** @test */
    function guest_cannot_forwarded_activation_code_account()
    {
        $this->withExceptionHandling();

        $this->post(route('account.activation.resend'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function user_with_active_account_cannot_forwarded_activation_code_account()
    {
        $this->actingAs($this->create(User::class))
            ->post(route('account.activation.resend'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

}
