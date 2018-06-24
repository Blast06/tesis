<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
// use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CreateArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        // return $this->showAll($articles);
        return response()->json(Article::all(), Response::HTTP_OK);
    }



    public function show($id)
    {

        // return $this->showOne($article);

        return response()->json(Article::where('id',$id)->first());


        
    }

    public function store(CreateArticleRequest $createArticleRequest)
    {
        return $createArticleRequest;
    }
}
