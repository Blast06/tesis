<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class MainSidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $website = request()->website ?? null;

        $websites = auth()->user()->websites()->take(10)->get();

        $subscriptions = auth()->user()->subscribedWebsite()->take(10)->get();

        $view->with(compact('website', 'websites', 'subscriptions'));
    }
}