<?php

namespace Tests\Feature\Auth;

use App\User;
use Mockery as  m;
use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\One\TwitterProvider;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TwitterLoginTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'email' => 'cristian@example.org',
        'name' => 'Cristian Gomez'
    ];

    /** @test */
    function login_requests_are_send_to_twitter()
    {
        $message = 'Redirecting to Twitter...';

        $this->mockTwitterProvider()
            ->shouldReceive('redirect')
            ->andReturn($message);

        $this->get(route('login.twitter'))
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($message);
    }

    /** @test */
    function new_users_authorized_by_twitter_are_registered_and_authenticated()
    {
        $this->withoutExceptionHandling();

        $this->mockTwitterUser();

        $response = $this->get(route('login.twitter.callback'));

        $this->assertDatabaseHas('users', $this->withData());

        $this->assertAuthenticated();

        $response->assertRedirect('/home');
    }

    /** @test */
    function known_new_users_authorized_by_twitter_are_registered_and_authenticated()
    {
        $this->create(User::class, [
            'email' => $this->defaultData['email'],
        ]);

        $this->mockTwitterUser();

        $response = $this->get(route('login.twitter.callback'));

        $this->assertAuthenticated();

        $response->assertRedirect('/home');
    }

    protected function mockTwitterUser()
    {
        $twitterUser = m::mock(SocialiteUser::class, [
            'getEmail' => $this->defaultData['email'],
            'getName' => $this->defaultData['name'],
        ]);

        $this->mockTwitterProvider()
            ->shouldReceive('user')->andReturn($twitterUser);
    }

    protected function mockTwitterProvider()
    {
        return tap(m::mock(TwitterProvider::class), function ($provider) {
            Socialite::shouldReceive('driver')->with('twitter')->andReturn($provider);
        });
    }
}
