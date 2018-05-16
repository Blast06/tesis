<?php

namespace App\Http\Controllers\API\V1\Web;

use App\Models\Website;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Website\ChangeImageRequest;
use App\Http\Requests\Website\UpdateWebsiteRequest;
use App\Http\Requests\Website\CreateWebsiteRequest;

class WebsiteController extends Controller
{
    public function store(CreateWebsiteRequest $request)
    {
        return response()->json($request->createWebsite(), Response::HTTP_CREATED);
    }

    public function subscribe(Website $website)
    {
        auth()->user()->subscribeTo($website);
        return response()->json(['message' => 'subscribe']);
    }

    public function unsubscribe(Website $website)
    {
        auth()->user()->unsubscribeTo($website);
        return response()->json(['message' => 'unsubscribe']);
    }

    public function image(ChangeImageRequest $request, Website $website)
    {
        $request->updateImage($website);
        return response()->json(['message' => 'imagen actualizada correctamente.'], Response::HTTP_OK);
    }

    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        $request->updateWebsite($website);

        return back()->with(['flash_success' => 'Actualizado correctamente.']);
    }
}
