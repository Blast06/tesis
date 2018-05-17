<?php

namespace App\Http\Controllers;

use App\Website;

class DashboardClientController extends Controller
{
    public function index(Website $website)
    {
        return view('client.dashboard', compact('website'));
    }
}
