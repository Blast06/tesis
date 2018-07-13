<?php

namespace App\Http\Controllers;

use App\Website;
use App\Http\Requests\CreateWebsiteRequest;
use Symfony\Component\HttpFoundation\Response;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show', 'information');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.website');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.website.create');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        $website->load(['articles']);
        return view('pages.website_client', compact('website'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateWebsiteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWebsiteRequest $request)
    {
        return $this->showOne($request->createWebsite(), Response::HTTP_CREATED);
    }

    /**
     * Subscribe the specified resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Website $website)
    {
        auth()->user()->subscribeTo($website);
        return $this->successResponse(['message' => 'subscribe']);
    }

    /**
     * Unsubscribe the specified resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(Website $website)
    {
        auth()->user()->unsubscribeTo($website);
        return $this->successResponse(['message' => 'unsubscribe']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function feed()
    {
        $feeds = auth()->user()->subscribedWebsite()->paginate();
        return view('pages.feed', compact('feeds'));
    }

    /**
     * @param \App\Website $website
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function information(Website $website)
    {
        return view('pages.website_client_information', compact('website'));
    }
}
