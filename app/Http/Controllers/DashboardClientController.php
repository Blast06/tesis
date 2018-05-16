<?php

namespace App\Http\Controllers;

use App\Models\Website;

class DashboardClientController extends Controller
{
    public function index(Website $website)
    {
        return view('client.dashboard', compact('website'));
    }
}
