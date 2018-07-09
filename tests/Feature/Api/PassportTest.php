<?php

namespace Tests\Feature\Api;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PassportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan('passport:client', ['--password' => null, '--no-interaction' => true]);

        $this->create(User::class, ['email' => 'cristiangomeze@hotmail.com']);
    }

    /** @test */
    function it_should_return_access_and_refresh_token_if_user_with_given_email_and_password_exists()
    {
        $client = \DB::table('oauth_clients')->where('password_client', 1)->first();

        $this->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => 'cristiangomeze@hotmail.com',
            'password' => 'secret',
        ])->assertJsonStructure(['access_token', 'refresh_token']);

    }

    /** @test */
    function it_should_return_new_access_token_if_user_refresh_the_token()
    {
        $client = \DB::table('oauth_clients')->where('password_client', 1)->first();

        $response = $this->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => 'cristiangomeze@hotmail.com',
            'password' => 'secret',
        ])->assertJsonStructure(['access_token', 'refresh_token']);

        $token = json_decode($response->getContent());

        $this->post('/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token->refresh_token,
            'client_id' => $client->id,
            'client_secret' => $client->secret
        ])->assertJsonStructure(['access_token', 'refresh_token']);
    }
}
