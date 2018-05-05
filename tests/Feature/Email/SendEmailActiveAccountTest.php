<?php

namespace Tests\Feature\Email;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserRegisteredSuccessfully;

class SendEmailActiveAccountTest extends TestCase
{
    private $name = 'Cristian Gomez';
    private $email = 'cristiangomeze@example.com';
    private $pass = 'L@aravel1';

    /** @test */
    function when_user_registered_send_activation_email()
    {
        Notification::fake();

        $this->post('/register', [
            'name' =>  $this->name,
            'email' => $this->email,
            'password' => $this->pass,
            'password_confirmation' => $this->pass
        ]);

        Notification::assertSentTo(
            [User::where('email', $this->email)->first()],
            UserRegisteredSuccessfully::class
        );
    }

    /** @test */
    function registration_email_only_send_user_that_is_registering()
    {
        Notification::fake();

        $this->post('/register', [
            'name' =>  $this->name,
            'email' => $this->email,
            'password' => $this->pass,
            'password_confirmation' => $this->pass
        ]);

        Notification::assertNotSentTo(
            [factory(User::class)->times(2)->create()],
            UserRegisteredSuccessfully::class
        );
    }
}
