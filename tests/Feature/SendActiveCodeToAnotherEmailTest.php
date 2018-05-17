<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendActiveCodeToAnotherEmailTest extends TestCase
{
    use RefreshDatabase;

    private $email = 'cristiangomeze@example.com';

    /** @test */
    function user_can_forwarded_activation_code_account()
    {
        Notification::fake();

        $user = factory(User::class)->create([
            'verified_at' => null
        ]);

        $this->actingAs($user)
            ->post(route('account.activation.change.email'), [
                'email' => $this->email
            ])->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $this->email
        ]);
    }

    /** @test */
    function guest_cannot_forwarded_activation_code_account()
    {
        $this->post(route('account.activation.change.email'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function user_with_active_account_cannot_forwarded_activation_code_account()
    {
        $this->actingAs($this->createUser())
            ->post(route('account.activation.change.email'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }
}
