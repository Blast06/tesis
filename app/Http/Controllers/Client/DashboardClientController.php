<?php

namespace App\Http\Controllers\Client;

use App\Website;
use App\Http\Controllers\Controller;

class DashboardClientController extends Controller
{
    public function index(Website $website)
    {
        return view('client.dashboard', compact('website'));
    }
}
