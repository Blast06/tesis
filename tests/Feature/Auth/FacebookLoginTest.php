<?php

namespace Tests\Feature\Auth;

use App\User;
use Mockery as m;
use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\FacebookProvider;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacebookLoginTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'email' => 'cristian@example.org',
        'name' => 'Cristian Gomez'
    ];

    /** @test */
    function login_requests_are_send_to_facebook ()
    {
        $message = 'Redirecting to Facebook...';

        $this->mockFacebookProvider()
            ->shouldReceive('redirect')
            ->andReturn($message);

        $this->get(route('login.facebook'))
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($message);
    }

    /** @test */
    function new_users_authorized_by_facebook_are_registered_and_authenticated()
    {
        $this->mockFacebookUser();

        $this->get(route('login.facebook.callback'))->assertRedirect('/home');

        $this->assertDatabaseHas('users', $this->withData());

        $this->assertAuthenticated();
    }

    /** @test */
    function known_new_users_authorized_by_facebook_are_registered_and_authenticated()
    {
        $this->create(User::class, [
            'email' => $this->defaultData['email']
        ]);

        $this->mockFacebookUser();

        $this->get(route('login.facebook.callback'))->assertRedirect('/home');

        $this->assertAuthenticated();
    }

    protected function mockFacebookUser()
    {
        $facebookUser = m::mock(SocialiteUser::class, [
            'getEmail' => $this->defaultData['email'],
            'getName' => $this->defaultData['name'],
        ]);

        $this->mockFacebookProvider()
            ->shouldReceive('user')->andReturn($facebookUser);
    }

    protected function mockFacebookProvider()
    {
        return tap(m::mock(FacebookProvider::class), function ($provider) {
            Socialite::shouldReceive('driver')->with('facebook')->andReturn($provider);
        });
    }
}
