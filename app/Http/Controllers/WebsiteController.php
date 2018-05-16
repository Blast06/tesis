<?php

namespace App\Http\Controllers;

use App\Models\Website;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create');
    }

    public function index()
    {
        $websites = Website::paginate();
        return view('pages.website', compact('websites'));
    }

    public function show(Website $website)
    {
        return view('client.website.public', compact('website'));
    }

    public function create()
    {
        return view('client.website.create');
    }

    public function edit(Website $website)
    {
        return view('client.website.edit', compact('website'));
    }
}
