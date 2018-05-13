<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeAvatarRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.profile');
    }

    public function avatar(ChangeAvatarRequest $request)
    {
        return $request->updateAvatar();
    }
}
