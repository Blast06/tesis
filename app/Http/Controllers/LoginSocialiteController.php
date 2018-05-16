<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginSocialiteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login With Twitter Methods
    |--------------------------------------------------------------------------
    */

    /**
     * @return mixed
     */
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /*
    |--------------------------------------------------------------------------
    | Login With Google Methods
    |--------------------------------------------------------------------------
    */

    /**
     * @return mixed
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /*
    |--------------------------------------------------------------------------
    | Login With Facebook Methods
    |--------------------------------------------------------------------------
    */

    /**
     * @return mixed
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
