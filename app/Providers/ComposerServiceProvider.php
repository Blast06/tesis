<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer(
            [
                'partials._sidenav',
                'client._sidebar'
            ]
            , 'App\Http\ViewComposers\MainSidebarComposer'
        );

        \View::composer('layouts.app', function ($view) {
            $app_name = request()->website->name ?? config('app.name', 'Laravel');
            $view->with(compact('app_name'));
        });
    }
}
