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
        $websites = auth()->user()->websites ?? [];

        $subscriptions = auth()->user()->subscribedWebsite;

        $view->with(compact('websites', 'subscriptions'));
    }
}