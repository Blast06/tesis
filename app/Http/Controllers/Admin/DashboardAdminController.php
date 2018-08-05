<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use App\{Article, User, Website, Category};

class DashboardAdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard')->with([
            'user_count' => User::count(),
            'website_count' => Website::count(),
            'articles_count' => Article::count(),
            'categories_count' => Category::count(),
            'chart' => $this->getCharStripe(),
        ]);
    }

    private function getCharStripe()
    {
        return [
            'labels' => DB::table('subscriptions')
                ->selectRaw('stripe_plan, count(user_id) AS `user_count`')
                ->groupBy('stripe_plan')
                ->get()
                ->map(function($item) { return $item->stripe_plan; }),
            'data' =>  DB::table('subscriptions')
                ->selectRaw('stripe_plan, count(user_id) AS `user_count`')
                ->groupBy('stripe_plan')
                ->get()
                ->map(function($item) { return $item->user_count; }),
        ];
    }
}
