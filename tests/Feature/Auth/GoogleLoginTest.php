<?php

namespace Tests\Feature\Auth;

use App\User;
use Mockery as  m;
use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'email' => 'cristian@example.org',
        'name' => 'Cristian Gomez'
    ];

    /** @test */
    function login_requests_are_send_to_google ()
    {
        $message = 'Redirecting to Google...';

        $this->mockGoogleProvider()
            ->shouldReceive('redirect')
            ->andReturn($message);

        $this->get(route('login.google'))
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($message);
    }

    /** @test */
    function new_users_authorized_by_google_are_registered_and_authenticated()
    {
        $this->mockGoogleUser();

        $this->get(route('login.google.callback'))->assertRedirect('/home');;

        $this->assertDatabaseHas('users', $this->withData());

        $this->assertAuthenticated();
    }

    /** @test */
    function known_new_users_authorized_by_google_are_registered_and_authenticated()
    {
        $this->create(User::class, [
            'email' => $this->defaultData['email']
        ]);

        $this->mockGoogleUser();

        $this->get(route('login.google.callback'))->assertRedirect('/home');

        $this->assertAuthenticated();
    }

    protected function mockGoogleUser()
    {
        $googleUser = m::mock(SocialiteUser::class, [
            'getEmail' => $this->defaultData['email'],
            'getName' => $this->defaultData['name']
        ]);

        $this->mockGoogleProvider()
            ->shouldReceive('user')->andReturn($googleUser);
    }

    protected function mockGoogleProvider()
    {
        return tap(m::mock(GoogleProvider::class), function ($provider) {
            Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
        });
    }

}
