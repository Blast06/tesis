<?php

namespace App\Http\Controllers;

use App\Website;
use App\Http\Requests\ChangeImageRequest;
use App\Http\Requests\CreateWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use Symfony\Component\HttpFoundation\Response;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show','index');
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
        return response()->json($request->createWebsite(), Response::HTTP_CREATED);
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        return response()->json($request->updateWebsite($website), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
        return response()->json(['message' => 'subscribe']);
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
        return response()->json(['message' => 'unsubscribe']);
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
        $request->updateImage($website);
        return response()->json(['message' => 'imagen actualizada correctamente.'], Response::HTTP_OK);
    }
}
