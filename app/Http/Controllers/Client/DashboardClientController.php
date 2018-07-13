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
        return view('client.dashboard', compact('website'));
    }
}
