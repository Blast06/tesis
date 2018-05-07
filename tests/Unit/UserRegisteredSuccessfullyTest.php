<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Notifications\UserRegisteredSuccessfully;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisteredSuccessfullyTest extends TestCase
{
    /** @test */
    public function it_builds_a_mail_message()
    {
        $user = new User([
            'token' => User::generateToken(),
            'verified_at' => null
        ]);

        $notification = new UserRegisteredSuccessfully($user);

        $message = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
          'Verificación de correo electrónico',
          $message->subject
        );

        $this->assertSame(
            "Hola {$user->name}",
            $message->greeting
        );

        $this->assertSame(
            "Usted se ha registrado exitosamente en ". config('app.name') .". Por favor active su cuenta",
            $message->introLines[0]
        );

        $this->assertSame(
            'ACTIVAR LA CUENTA',
            $message->actionText
        );

        $this->assertSame(
            $user->signedTokenUrl(),
            $message->actionUrl
        );
    }
}
