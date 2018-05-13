<?php

namespace Tests\Feature\Notification;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PleaseConfirmYourEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PleaseConfirmYourEmailTest extends TestCase
{
    use RefreshDatabase;

    private $name = 'Cristian Gomez';
    private $email = 'cristiangomeze@example.com';
    private $pass = 'L@aravel1';

    /** @test */
    function when_user_registered_successfully_sent_account_activation_email()
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
            PleaseConfirmYourEmail::class
        );
    }

    /** @test */
    function only_registered_successfully_user_sent_account_activation_email()
    {
        $this->post('/register', [])
            ->assertSessionHasErrors(['name','email','password']);
    }

    /** @test */
    function account_activation_email_only_sent_user_registed_successfully()
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
            PleaseConfirmYourEmail::class
        );
    }
}
