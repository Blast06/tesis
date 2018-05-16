<?php

namespace App\Http\Controllers\API\V1\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeAvatarRequest;

class UserController extends Controller
{
    public function avatar(ChangeAvatarRequest $request)
    {
        return $request->updateAvatar();
    }
}
