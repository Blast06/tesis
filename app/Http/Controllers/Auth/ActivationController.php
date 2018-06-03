<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\User;
use App\Http\Controllers\Controller;
use App\Notifications\PleaseConfirmYourEmail;

class ActivationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('activate');
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate($token)
    {
        if (request()->hasValidSignature()) {

            tap($this->findUserByCode($token), function ($user) {
                $user->token = null;
                $user->verified_at = Carbon::now()->format('Y-m-d H:i:s');
                $user->save();
                auth()->loginUsingId($user->id);
            });

            return redirect('/home')->with(['flash_success' => '¡Tu cuenta ahora está confirmada!']);
        }
        return redirect('/home')->with(['flash_danger' => 'Token desconocido']);
    }

    public function indexResendActivationCode()
    {
        if (auth()->user()->isActive()) return redirect('/home');

        return view('auth.resend_activation_code');
    }

    public function resendActivationCode()
    {
        if (auth()->user()->isActive()) return redirect('/home');

        tap($this->findUserAuth(), function ($user) {
            $user->token = User::generateToken();
            $user->save();
            $user->notify(new PleaseConfirmYourEmail($user));
        });

        return back()->with('flash_success', 'Se a reenviado el enlace de activación, por favor revisa tu correo electrónico.');
    }

    public function indexChangeEmail()
    {
        if (auth()->user()->isActive()) return redirect('/home');

        return view('auth.change_email');
    }

    public function changeEmailAndResendActivationCode()
    {
        if (auth()->user()->isActive()) return redirect('/home');

        $campos = request()->validate([
            'email' => 'required|email|max:255|unique:users,email,'. auth()->id(),
        ]);

        tap($this->findUserAuth(), function ($user) use($campos){
            $user->token = User::generateToken();
            $user->email = $campos['email'];
            $user->save();
            $user->notify(new PleaseConfirmYourEmail($user));
        });

        return back()
            ->with('flash_success', 'Se a cambiado tu correo electrónico, Por favor revisa tu correo electrónico para ver el enlace de activación.');
    }

    protected function findUserByCode($token)
    {
        return User::where('token', $token)->whereNull('verified_at')->firstOrFail();
    }

    protected function findUserAuth()
    {
        return User::where('id', auth()->id())->whereNull('verified_at')->firstOrFail();
    }
}
