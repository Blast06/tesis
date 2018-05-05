<?php

namespace Tests\Feature\Register;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class ResendActiveCodeTest extends TestCase
{
    /** @test */
    function user_can_forwarded_activation_code_account()
    {
        Notification::fake();

        $user = factory(User::class)->create([
            'verified_at' => null
        ]);

        $this->actingAs($user)
            ->post(route('account.activation.resend'), [])
            ->assertStatus(Response::HTTP_FOUND);

        $user->refresh();

        $this->assertTrue(
            $user->activation_code !== null
        );
    }

    /** @test */
    function guest_cannot_forwarded_activation_code_account()
    {
        $this->post(route('account.activation.resend'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function user_with_active_account_cannot_forwarded_activation_code_account()
    {
        $this->actingAs($this->createUser())
            ->post(route('account.activation.resend'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

}
