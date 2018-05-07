<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Notifications\UserRegisteredSuccessfully;

class ActivationController extends Controller
{
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

            return redirect('/home')->with(['flash_success' => 'Cuenta activada exitosamente']);
        }

        abort(404);
    }

    public function request()
    {
        if (auth()->user()->isActive()) return redirect('/home');

        return view('auth.activation');
    }

    public function resend()
    {
        if (auth()->user()->isActive()) return redirect('/home');

        tap($this->findUserAuth(), function ($user) {
            $user->token = User::generateToken();
            $user->save();
            $user->notify(new UserRegisteredSuccessfully($user));
        });

        return back()->with('flash_success', 'Por favor revisa tu correo electrónico para ver el enlace de activación');
    }

    public function changeEmailResend()
    {
        if (auth()->user()->isActive()) return redirect('/home');

        $campos = request()->validate([
            'email' => 'required|email|max:255|unique:users,email,'. auth()->id(),
        ]);

        tap($this->findUserAuth(), function ($user) use($campos){
            $user->token = User::generateToken();
            $user->email = $campos['email'];
            $user->save();
            $user->notify(new UserRegisteredSuccessfully($user));
        });

        return redirect()->route('account.activation.request')->with('flash_success', 'Por favor revisa tu correo electrónico para ver el enlace de activación');
    }

    private function findUserByCode($token)
    {
        return User::where('token', $token)->whereNull('verified_at')->firstOrFail();
    }

    private function findUserAuth()
    {
        return User::where('id', auth()->id())->whereNull('verified_at')->firstOrFail();
    }
}
