<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        //probando
        return $this->showAll(User::all());

    }
}
