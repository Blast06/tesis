<?php

namespace App\Http\Controllers;

class MarketingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.marketing');
    }

    public function pricing()
    {
        return view('pages.pricing');
    }
}
