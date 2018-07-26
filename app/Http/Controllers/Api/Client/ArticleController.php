<?php

namespace App\Http\Controllers\Api\Client;

use App\Article;
use App\Website;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UploadImageArticleRequest;

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param \App\Website $website
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Website $website)
    {
        return $this->successResponse(['data' => Article::with(['subCategory'])->where('website_id', $website->id)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateArticleRequest $request
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArticleRequest $request, Website $website)
    {
        return $this->showOne($request->createArticle($website), Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateArticleRequest $request
     * @param \App\Website $website
     * @param \App\Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateArticleRequest $request, Website $website, Article $article)
    {
        return $this->successResponse(['data' => $request->updateArticle($article)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Website $website
     * @param \App\Article $article
     * @return \App\Article
     * @throws \Exception
     */
    public function destroy(Website $website, Article $article)
    {
        $article->delete();
        return $this->showOne($article, Response::HTTP_OK);
    }

    /**
     * Upload Image to the specified resource from storage.
     *
     * @param \App\Http\Requests\UploadImageArticleRequest $request
     * @param \App\Website $website
     * @return void
     */
    public function images(UploadImageArticleRequest $request, Website $website)
    {
        $this->showOne($request->uploadImage($website), Response::HTTP_OK);
    }
}
