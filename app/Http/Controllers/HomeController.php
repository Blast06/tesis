<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $articles = auth()->user()
            ->subscribedWebsite()
            ->with('articles')
            ->get()
            ->pluck('article')
            ->collapse()
            ->unique('id')
            ->values();

        return view('pages.home', compact('articles'));
    }
}
