<?php

namespace App\Http\Controllers;

use App\{Article, Review};

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->with('reviews.user')
            ->firstOrFail();

        $relateds = Article::where([
            ['sub_category_id', $article->sub_category_id],
            ['id', '<>', $article->id],
        ])->take(10)->get();

        $user_review = Review::query()
            ->where([
                ['article_id', $article->id],
                ['user_id', auth()->id() ?? 0],
            ])
            ->first();

        return view('pages.article', compact('article', 'relateds', 'user_review'));
    }

    /**
     * Favorite Article to user
     *
     * @param \App\Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function favorite(Article $article)
    {
        auth()->user()->favoriteTo($article);
        return $this->successResponse(['message' => "Article {$article->name} is now favorited"]);
    }

    /**
     * Unfavorite Article to user
     *
     * @param \App\Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function unfavorite(Article $article)
    {
        auth()->user()->unfavoriteTo($article);
        return $this->successResponse(['message' => "Article {$article->name} is now unfavorited"]);
    }
}
