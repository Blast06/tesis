<?php

namespace App\Http\Controllers\Website;

use App\Models\Website;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Website\CreateWebsiteRequest;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create','store');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $websites = Website::paginate();
        return view('pages.website', compact('websites'));
    }

    public function show(Website $website)
    {
        return view('client.website.public', compact('website'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('client.website.create');
    }

    /**
     * @param \App\Http\Requests\Website\CreateWebsiteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateWebsiteRequest $request)
    {
        return response()->json(['data' => $request->createWebsite()], Response::HTTP_CREATED);
    }
}
