<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_can_reset_password()
    {
        Notification::fake();

        $user = $this->create(User::class);

        $this->post(route('password.email'), [
           'email' => $user->email
        ])->assertSessionHas(['status' => '¡Recordatorio de contraseña enviado!']);

        Notification::assertSentTo(
            [$user],
            ResetPasswordNotification::class
        );
    }

    /** @test */
    function guest_cannot_reset_password_with_invalid_email()
    {
        $this->post(route('password.email'), [
            'email' => 'fake.email@example.com'
        ])->assertSessionHasErrors(['email' => 'No se ha encontrado un usuario con esa dirección de correo.']);
    }

    /** @test */
    function reset_password_it_only_sends_it_to_the_user_with_said_email()
    {
        Notification::fake();

        $users = $this->create(User::class, [], 2);

        $this->post(route('password.email'), [
            'email' => $users[0]->email
        ])->assertSessionHas(['status' => '¡Recordatorio de contraseña enviado!']);

        Notification::assertSentTo(
            [$users[0]],
            ResetPasswordNotification::class
        );

        Notification::assertNotSentTo(
            [$users[1]],
            ResetPasswordNotification::class
        );
    }
}
