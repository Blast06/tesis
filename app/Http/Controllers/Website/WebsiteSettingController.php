<?php

namespace App\Http\Controllers\Website;

use App\Models\Website;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ChangeImageRequest;
use App\Http\Requests\Website\UpdateWebsiteRequest;

class WebsiteSettingController extends Controller
{
    public function index(Website $website)
    {
        return view('client.website.edit', compact('website'));
    }

    public function image(ChangeImageRequest $request, Website $website)
    {
        return response()->json(['message' =>  $request->updateImage($website)], 200);
    }

    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        $request->updateWebsite($website);

        return back()->with(['flash_success' => 'Actualizado correctamente.']);
    }
}
