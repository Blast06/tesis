<?php

namespace App\Http\Controllers\Api;

use App\Website;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeImageRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use App\Http\Requests\CreateWebsiteRequest;
use Symfony\Component\HttpFoundation\Response;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('show');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        return $this->successResponse(['data' => $website->load(['articles'])]);
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
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateWebsiteRequest $request
     * @param \App\Website $website
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        return $this->successResponse(['data' => $request->updateWebsite($website)]);
    }

    /**
     * Image upload the specified resource in storage.
     *
     * @param \App\Http\Requests\ChangeImageRequest $request
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function image(ChangeImageRequest $request, Website $website)
    {
        return $this->successResponse(['message' => $request->updateImage($website)]);
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
   
}
