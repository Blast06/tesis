<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeAvatarRequest;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.profile');
    }

    /**
     * Avatar Upload the specified resource in storage.
     *
     * @param \App\Http\Requests\ChangeAvatarRequest $request
     * @return \Illuminate\Http\Response
     */
    public function avatar(ChangeAvatarRequest $request)
    {
        return $this->responseMessage($request->updateAvatar());
    }
}
