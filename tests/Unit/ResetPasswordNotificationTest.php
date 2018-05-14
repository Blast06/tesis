<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotificationTest extends TestCase
{
    /** @test */
    public function it_builds_a_mail_message()
    {
        $user = new User([
            'token' => User::generateToken(),
            'name' => 'cris'
        ]);

        $notification = new ResetPasswordNotification($user->token);

        $message = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
            'Solicitud de restablecimiento de contraseña',
            $message->subject
        );

        $this->assertSame(
            "¡Hola {$user->name}!",
            $message->greeting
        );

        $this->assertSame(
            "Usted está recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.",
            $message->introLines[0]
        );

        $this->assertSame(
            'Restablecer la contraseña',
            $message->actionText
        );

        $this->assertSame(
            config('app.url') .'/password/reset/'. $user->token,
            $message->actionUrl
        );
    }
}
