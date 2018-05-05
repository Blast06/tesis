<?php

namespace App\Http\Controllers\LoginSocialite;

use App\Models\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $userFacebook = Socialite::driver('facebook')->user();

        $appUser =  User::firstOrCreate([
            'email' => $userFacebook->getEmail(),
        ], [
            'name' => $userFacebook->getName(),
        ]);

        auth()->login($appUser);

        return redirect('/home');
    }
}
