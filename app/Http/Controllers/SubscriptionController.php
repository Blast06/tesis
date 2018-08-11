<?php

namespace App\Http\Controllers;


class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Si tengo una suscripcion no puedo ver estos metodos
        $this->middleware(function ($request, $next) {

            if (auth()->user()->subscribed('main')) {
                return redirect('/subscription/admin')
                    ->with(['flash_danger' => "Actualmente ya estas suscrito a un plan"]);
            }
            return $next($request);
        })->only(['plans', 'processSubscription']);

        // Si no tengo una suscripcion no puedo ver estos metodos
        $this->middleware(function ($request, $next) {
            if (! auth()->user()->subscribed('main')) {
                return redirect('/plans')
                    ->with(['flash_danger' => "Debes elegir un plan, para poder ver la sección anterior"]);
            }

            return $next($request);
        })->only(['admin', 'resume', 'cancel', 'change']);
    }

    public function plans()
    {
        return view('pages.plans');
    }

    public function processSubscription()
    {
        $token = request('stripeToken');
        try {
            if (request()->has('coupon') && !is_null(request('coupon'))) {
                request()->user()->newSubscription('main', request('type'))
                    ->withCoupon(request('coupon'))->create($token);
            }else{
                request()->user()->newSubscription('main', request('type'))
                    ->create($token);
            }

            return redirect()->route('subscriptions.admin')
                ->with(['flash_success' => "Te haz suscrito de manera exito en nuestro plan ".request('type').""]);
        }catch (\Exception $exception) {
            return back()->with(['flash_danger' => $exception->getMessage()]);
        }
    }

    public function admin()
    {
        $subscription = auth()->user()->subscriptions()->first();
        return view('pages.subscriptions_admin', compact('subscription'));
    }

    public function resume()
    {
        $suscripcion = request()->user()->subscription(request('plan'));

        if ($suscripcion->cancelled() && $suscripcion->onGracePeriod()) {
            request()->user()->subscription(request('plan'))->resume();
            return back()->with(['flash_success' => 'Has reanudado tu suscripcion correctamente']);
        }

        return back()->with(['flash_danger' => 'Has dejado finalizar tu suscripcion']);
    }

    public function cancel()
    {
        auth()->user()->subscription(request('plan'))->cancel();
        return back()->with(['flash_success' => 'La suscripcion se ha cancelado correctamente']);
    }

    public function change()
    {
        try{
            auth()->user()->subscription('main')->swap(request('plan'));
            return back()->with(['flash_success' => 'Has actualizado tu plan correctamente']);
        }catch (\Exception $exception) {
            return back()->with(['flash_danger' => $exception->getMessage()]);
        }
    }
}
