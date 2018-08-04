<?php

namespace App\Http\Controllers\Client;

use App\Website;
use App\Http\Controllers\Controller;

class DashboardClientController extends Controller
{
    /**
     * @param \App\Website $website
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Website $website)
    {
        $chart = [
          'labels' => $website->orders()
              ->with('article:id,name')
              ->selectRaw('article_id, count(article_id) AS `order_article_count`')
              ->groupBy('article_id')
              ->take(20)
              ->get()
              ->map(function($item) { return $item->article->name; }),
            'data' =>  $website->orders()
                ->with('article:id,name')
                ->selectRaw('article_id, count(article_id) AS `order_article_count`')
                ->groupBy('article_id')
                ->take(20)
                ->get()
                ->map(function($item) { return $item->order_article_count; }),
        ];

        return view('client.dashboard', compact('website', 'chart'));
    }
}
