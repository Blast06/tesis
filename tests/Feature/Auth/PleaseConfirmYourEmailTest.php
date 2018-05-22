<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PleaseConfirmYourEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PleaseConfirmYourEmailTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Cristian Gomez',
        'email' => 'cristiangomeze@example.com',
        'password' => 'L@aravel1',
        'password_confirmation' => 'L@aravel1'
    ];

    /** @test */
    function when_user_registered_successfully_sent_account_activation_email()
    {
        Notification::fake();

        $this->post('/register', $this->withData());

        Notification::assertSentTo(
            [User::where('email', $this->defaultData['email'])->first()],
            PleaseConfirmYourEmail::class
        );
    }

    /** @test */
    function only_registered_successfully_user_sent_account_activation_email()
    {
        $this->handleValidationExceptions();

        $this->post('/register', [])
            ->assertSessionHasErrors(['name','email','password']);
    }

    /** @test */
    function account_activation_email_only_sent_user_registed_successfully()
    {
        Notification::fake();

        $this->post('/register', $this->withData());

        Notification::assertNotSentTo(
            [$this->create(User::class, [], 2)],
            PleaseConfirmYourEmail::class
        );
    }
}
