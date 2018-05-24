<?php

namespace App\Http\Controllers;

use App\Website;
use App\Http\Requests\CreateWebsiteRequest;
use Symfony\Component\HttpFoundation\Response;

class PublicWebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create','store','subscribe','unsubscribe');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::paginate();
        return view('pages.website', compact('websites'));
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
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateWebsiteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWebsiteRequest $request)
    {
        return $this->responseOne($request->createWebsite(), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        return view('client.website.public', compact('website'));
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
        return $this->responseMessage('subscribe');
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
        return $this->responseMessage('unsubscribe');
    }
}
