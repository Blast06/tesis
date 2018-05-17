<?php

namespace Tests\Unit;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\URL;

class UserSignedTokenUrlTest extends TestCase
{
    /** @test */
    function user_model_can_generate_signed_token_url()
    {
        $userA_NotVerified = new User(['token' =>  User::generateToken()]);

        $userB_NotVerified = new User(['token' =>  User::generateToken()]);

        $userC_Verified = new User;
        $userC_Verified->verified_at = Carbon::now();

        $this->assertNotNull($userA_NotVerified->signedTokenUrl());

        $this->assertNotNull($userB_NotVerified->signedTokenUrl());

        $this->assertNull($userC_Verified->signedTokenUrl());

        $this->assertTrue(
            $userA_NotVerified->signedTokenUrl() === $this->generateSignedUrl($userA_NotVerified->token)
        );

        $this->assertTrue(
            $userB_NotVerified->signedTokenUrl() === $this->generateSignedUrl($userB_NotVerified->token)
        );

        $this->assertFalse(
            $userA_NotVerified->signedTokenUrl() === $this->generateSignedUrl($userA_NotVerified->token, 1)
        );

        $this->assertFalse(
            $userB_NotVerified->signedTokenUrl() === $this->generateSignedUrl($userB_NotVerified->token, 1)
        );
    }

    /** @test */
    function user_model_change_signed_token_url_on_change_token()
    {
        $userA = new User(['token' => User::generateToken()]);

        $old_url = $userA->signedTokenUrl();

        $userA->token = User::generateToken();

        $this->assertTrue(
            $userA->signedTokenUrl() !== $old_url
        );

        $this->assertFalse(
            $userA->signedTokenUrl() === $old_url
        );

    }

    private function generateSignedUrl($token, $minutes = 30)
    {
        return URL::temporarySignedRoute(
            'account.activate', now()->addMinutes($minutes), ['token' => $token]
        );
    }
}
