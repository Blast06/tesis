<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendActiveCodeToAnotherEmailTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
      'email' => 'cristiangomeze@example.com'
    ];

    /** @test */
    function user_can_forwarded_activation_code_account()
    {
        Notification::fake();

        $user = $this->create(User::class, [
            'verified_at' => null
        ]);

        $this->actingAs($user)
            ->post(route('activate.change.email'), $this->defaultData)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas(['flash_success' => 'Se a cambiado tu correo electrónico, Por favor revisa tu correo electrónico para ver el enlace de activación.']);

        $this->assertDatabaseHas('users', $this->withData([
            'id' => $user->id,
        ]));
    }

    /** @test */
    function guest_cannot_forwarded_activation_code_account()
    {
        $this->withExceptionHandling();

        $this->post(route('activate.change.email'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function user_with_active_account_cannot_forwarded_activation_code_account()
    {
        $this->actingAs($this->create(User::class))
            ->post(route('activate.change.email'), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }
}
