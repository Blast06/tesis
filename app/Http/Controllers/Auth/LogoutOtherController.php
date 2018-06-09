<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogoutOtherDevicesRequest;

class LogoutOtherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logoutOtherDevices(LogoutOtherDevicesRequest $request)
    {
        return redirect()->back()->with(['flash_success' => $request->logoutOtherDevices()]);
    }
}
