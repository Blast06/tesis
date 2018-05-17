<?php

namespace Tests\Feature;

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

    private $email = 'cristian@example.org';
    private $name = 'Cristian Gomez';

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

        $this->assertDatabaseHas('users', [
            'email' => $this->email,
            'name' => $this->name,
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect('/home');
    }

    /** @test */
    function known_new_users_authorized_by_twitter_are_registered_and_authenticated()
    {
        factory(User::class)->create([
            'email' => $this->email
        ]);

        $this->mockTwitterUser();

        $response = $this->get(route('login.twitter.callback'));

        $this->assertAuthenticated();

        $response->assertRedirect('/home');
    }

    protected function mockTwitterUser()
    {
        $twitterUser = m::mock(SocialiteUser::class, [
            'getEmail' => $this->email,
            'getName' => $this->name,
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
