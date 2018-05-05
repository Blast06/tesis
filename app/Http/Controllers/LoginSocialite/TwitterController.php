<?php

namespace App\Http\Controllers\LoginSocialite;

use App\Models\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class TwitterController extends Controller
{
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterCallback()
    {
        $userTwitter = Socialite::driver('twitter')->user();

        $appUser =  User::firstOrCreate([
            'email' => $userTwitter->getEmail(),
        ], [
            'name' => $userTwitter->getName(),
        ]);

        auth()->login($appUser);

        return redirect('/home');
    }
}
