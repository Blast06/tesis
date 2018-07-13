<?php

namespace App\Http\Controllers\Client;

use App\Website;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeImageRequest;
use App\Http\Requests\CreateWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use Symfony\Component\HttpFoundation\Response;

class WebsiteController extends Controller
{
    /**
     * WebsiteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function edit(Website $website)
    {
        return view('client.website.edit', compact('website'));
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
}
