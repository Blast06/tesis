<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        return $this->showAll(Article::all());
    }

    public function show(Article $article)
    {
        return $this->showOne($article);
    }

    public function store(CreateArticleRequest $request)
    {
        return $this->showOne($request->createArticle());
    }
}
