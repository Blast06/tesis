<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\{CreateArticleRequest, UploadImageArticleRequest};
use App\{
    DataTables\ClientArticleDataTable, Http\Requests\UpdateArticleRequest, Review, Website, Article
};

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\ClientArticleDataTable $dataTable
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(ClientArticleDataTable $dataTable, Website $website)
    {
        $header = 'Todos los articulos de '. $website->name;

        $breadcrumb_name = 'article';

        return $dataTable->render('datatables.index', compact('header', 'breadcrumb_name', 'website'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function create(Website $website)
    {
        return view('client.article.create', compact('website'));
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
     * Show the form for editing the specified resource.
     *
     * @param \App\Website $website
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Website $website, Article $article)
    {
        return view('client.article.edit', compact('website', 'article'));
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

        if (request()->ajax()) { return $this->showOne($article, Response::HTTP_OK); }

        return redirect()->route('articles.index', $website);
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
