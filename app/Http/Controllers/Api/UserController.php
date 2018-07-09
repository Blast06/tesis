<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Este metodo devolvera la informacion del usuario actual, Los sitios que tiene creado y los sitios a los cuales esta subcrito
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return $this->showOne(auth()->user()->load(['websites', 'subscribedWebsite']));
    }
}
