<?php

namespace App\Http\Controllers\Client;

use App\Website;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    /**
     * @param \App\Website $website
     * @param \Spatie\MediaLibrary\Models\Media $media
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Website $website, Media $media)
    {
        $media->delete();
        return redirect()->back()->with(['flash_success' => 'Media borrada con éxito']);
    }
}
