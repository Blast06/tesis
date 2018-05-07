<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Website;
use App\Http\Controllers\Controller;

class ClientDashboardController extends Controller
{
    public function index(Website $website)
    {
        return view('client.dashboard', compact('website'));
    }
}
