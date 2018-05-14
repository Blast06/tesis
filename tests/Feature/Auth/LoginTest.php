<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_can_login_on_system()
    {
        $user = factory(User::class)->create([
            'email' => 'cristiangomeze@example.com',
            'password' => 'secret'
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ])->assertRedirect('/home');

        $this->assertAuthenticated();
    }

    /** @test */
    function guest_can_see_errors_on_login_form()
    {
        $user = factory(User::class)->create([
            'email' => 'cristiangomeze@example.com',
            'password' => 'secret'
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secreto'
        ])->assertSessionHasErrors(['email']);

        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    function guest_cannot_sent_empty_login_form()
    {
        $user = factory(User::class)->create([
            'email' => 'cristiangomeze@example.com',
            'password' => 'secret'
        ]);

        $this->post('/login', [])
            ->assertSessionHasErrors(['email','password']);

        $this->assertFalse($this->isAuthenticated());
    }
}
