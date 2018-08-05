<?php

namespace App\Http\Controllers;


class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {

            if (auth()->user()->subscribed('main')) {
                return redirect('/subscription/admin')
                    ->with(['flash_danger' => "Actualmente ya estas suscrito a un plan"]);
            }
            return $next($request);
        })->only(['plans', 'processSubscription']);
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

            return redirect()->route('subscriptions.admin');
        }catch (\Exception $exception) {
            return back()->with(['flash_danger' => $exception->getMessage()]);
        }
    }

    public function admin()
    {
        $subscriptions = auth()->user()->subscriptions;
        return view('pages.subscriptions_admin', compact('subscriptions'));
    }

    public function resume()
    {
        $suscripcion = request()->user()->subscription(request('plan'));

        if ($suscripcion->cancelled() && $suscripcion->onGracePeriod()) {
            request()->user()->subscription(request('plan'))->resume();
            return back()->with(['flash_success' => 'Has reanudado tu suscripcion correctamente']);
        }

        return back();
    }

    public function cancel()
    {
        auth()->user()->subscription(request('plan'))->cancel();
        return back()->with(['flash_success' => 'La suscripcion se ha cancelado correctamente']);
    }
}
