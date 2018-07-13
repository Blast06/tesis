<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('search');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $articles = auth()->user()
            ->subscribedWebsite()
            ->with('articles')
            ->get()
            ->pluck('articles')
            ->collapse()
            ->unique('id')
            ->values();

        return view('pages.home', compact('articles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        return view('pages.search');
    }
}
