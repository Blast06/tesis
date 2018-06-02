<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use Symfony\Component\HttpFoundation\Response;
use App\{Http\Requests\UpdateArticleRequest, Website, Article};

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(Website $website)
    {
        $header = 'Todos los articulos de '. $website->name;

        $breadcrumb_name = 'article';

        $articles = Article::with(['subCategory'])->where('website_id', $website->id)->paginate();

        return view('client.article.index', compact('header', 'breadcrumb_name', 'website', 'articles'));
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
        return $this->responseOne($request->createArticle($website), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('pages.article', compact('article'));
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
        return $this->responseOne($request->updateArticle($article), Response::HTTP_OK);
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

        if (request()->ajax()) { return $this->responseOne($article, Response::HTTP_OK); }

        return redirect()->route('articles.index', $website);
    }
}
