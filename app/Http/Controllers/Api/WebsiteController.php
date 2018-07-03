<?php

namespace App\Http\Controllers\Api;

use App\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWebsiteRequest;

class WebsiteController extends Controller
{
    
    public function index()
    {
        return $this->showAll(Website::all());

    }

    public function show($user_id)
    {
        $websites = Website::where('user_id', $user_id)->get();

        return response()->json($websites);
    }

    public function store(CreateWebsiteRequest $request)
    {
        Website::Create($request->all());
        // return $this->showOne($request->createWebsite(), Response::HTTP_CREATED);
        
        
        return response()->json(['message' => "Sitio creado exitosamente!"], Response::HTTP_OK);
        

    }

   
}
