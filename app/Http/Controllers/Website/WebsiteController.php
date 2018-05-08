<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Website\CreateWebsiteRequest;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('client.website.create');
    }

    public function store(CreateWebsiteRequest $request)
    {
        $website = auth()->user()->websites()->create($request->validated());

        return response()->json(['data' => $website], Response::HTTP_CREATED);
    }
}
