<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PleaseConfirmYourEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PleaseConfirmYourEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function when_user_registered_successfully_sent_account_activation_email()
    {
        Notification::fake();

        $this->post('/register', $this->getData());

        Notification::assertSentTo(
            [User::where('email', $this->getData()['email'])->first()],
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

        $this->post('/register', $this->getData());

        Notification::assertNotSentTo(
            [factory(User::class)->times(2)->create()],
            PleaseConfirmYourEmail::class
        );
    }

    protected function getData($data = [])
    {
        return array_filter(array_merge([
            'name' => 'Cristian Gomez',
            'email' => 'cristiangomeze@example.com',
            'password' => 'L@aravel1',
            'password_confirmation' => 'L@aravel1'
        ],$data));
    }
}
