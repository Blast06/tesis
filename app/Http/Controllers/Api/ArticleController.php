<?php

namespace App\Http\Controllers\Api;

use App\{Article, Review, Website};
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\UploadImageArticleRequest;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('show');
    }

    public function index(Website $website)
    {
        return $this->successResponse(['data' => Article::with(['subCategory'])->where('website_id', $website->id)->get()]);
    }

    /**
     * Este metodo mostrara un articulo en especifico con sus reviews (comentarios y valoracion), Articulos relacionados
     * y la valoracion del usuario actual (si no esta connectado o este no valoro el articulo current_user_review devolvera null)
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
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

        return $this->successResponse([
            'data' => [
                'article' => $article,
                'relateds' => $relateds,
                'current_user_review' => $user_review
            ]
        ]);
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
     * Este metodo devuelve todos los articulos de los sitios a los que esta suscrito un usuario
     * (Ojo esta sin paginar no lo veo necesario, ya que es una colecion y no se pagina los datos como lo hace eloquent)
     *
     * @return mixed
     */
    public function articleOfMySubscribed()
    {
        return $this->successResponse([
            'data' => auth()->user()
                ->subscribedWebsite()
                ->with('articles')
                ->paginate()
                ->pluck('articles')
                ->collapse()
                ->unique('id')
                ->values()
        ]);
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
