<?php

namespace App\Http\Controllers\Api;

use App\Review;
use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    /**
     * ReviewController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateReviewRequest $request
     * @param \App\Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateReviewRequest $request, Article $article)
    {
        $this->currentUserOwnTo($article);
        return $this->showOne($request->createReview($article), Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateReviewRequest $request
     * @param \App\Article $article
     * @param  \App\Review $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateReviewRequest $request, Article $article, Review $review)
    {
        $this->currentUserOwnTo($article);
        return $this->showOne($request->updateReview($review));
    }

    /**
     * @param \App\Article $article
     */
    private function currentUserOwnTo(Article $article): void
    {
        abort_if(auth()->id() === $article->website->user->id, Response::HTTP_FORBIDDEN);
    }
}
