<?php

namespace Tests\Feature;

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

    private $email = 'cristian@example.org';
    private $name = 'Cristian Gomez';

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

        $response = $this->get(route('login.facebook.callback'));

        $this->assertDatabaseHas('users', [
            'email' => $this->email,
            'name' => $this->name,
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect('/home');
    }

    /** @test */
    function known_new_users_authorized_by_facebook_are_registered_and_authenticated()
    {
        factory(User::class)->create([
            'email' => $this->email
        ]);

        $this->mockFacebookUser();

        $response = $this->get(route('login.facebook.callback'));

        $this->assertAuthenticated();

        $response->assertRedirect('/home');
    }

    protected function mockFacebookUser()
    {
        $facebookUser = m::mock(SocialiteUser::class, [
            'getEmail' => $this->email,
            'getName' => $this->name,
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
