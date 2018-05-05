<?php

namespace App\Http\Controllers\LoginSocialite;

use App\Models\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $userGoogle = Socialite::driver('google')->user();

        $appUser =  User::firstOrCreate([
            'email' => $userGoogle->getEmail(),
        ], [
            'name' => $userGoogle->getName(),
        ]);

        auth()->login($appUser);

        return redirect('/home');
    }
}
