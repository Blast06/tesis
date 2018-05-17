<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use App\Notifications\PleaseConfirmYourEmail;
use Illuminate\Notifications\Messages\MailMessage;

class PleaseConfirmYourEmailTest extends TestCase
{
    /** @test */
    public function it_builds_a_mail_message()
    {
        $user = new User([
            'token' => User::generateToken(),
            'verified_at' => null
        ]);

        $notification = new PleaseConfirmYourEmail($user);

        $message = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
          'Verificación de correo electrónico',
          $message->subject
        );

        $this->assertSame(
            "Hola {$user->name}, Un último paso.",
            $message->greeting
        );

        $this->assertSame(
            "Solo necesitamos que confirmes tu dirección de correo electrónico para demostrar que eres humano. Lo entiendes, ¿verdad? Coo.",
            $message->introLines[0]
        );

        $this->assertSame(
            'Confirmar correo electrónico',
            $message->actionText
        );

        $this->assertSame(
            $user->signedTokenUrl(),
            $message->actionUrl
        );
    }
}
