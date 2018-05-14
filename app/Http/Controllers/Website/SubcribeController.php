<?php

namespace App\Http\Controllers\Website;

use App\Models\Website;
use App\Http\Controllers\Controller;

class SubcribeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
}
