<?php

namespace App\Http\Controllers\Api;

use App\{Article, Review};
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('show','allArticles');

        $this->middleware(function ($request, $next) {

            if (App::environment('testing') || auth()->user()->isAdmin()) {
                return $next($request);
            }

            abort_unless(auth()->user()->subscribed('main'), 403, "Debes elegir un plan antes de continuar");

            abort_if(auth()->user()->subscribedToPlan('comunidad', 'main')
                && request()->website->articles()->count() > 5, 403, 'Tu plan no te permite crear maas de 5 articulos');

            abort_if(auth()->user()->subscribedToPlan('esencial', 'main')
                && request()->website->articles()->count() > 10, 403, 'Tu plan no te permite crear maas de 10 articulos');

            abort_if(auth()->user()->subscribedToPlan('premium', 'main')
                && request()->website->articles()->count() > 20, 403, 'Tu plan no te permite crear maas de 20 articulos');

            return $next($request);
        })->only('store');
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

    /*
    * Shows articles
    */
    public function allArticles()
    {
        $articles = Article::all();
        return response()->json($articles,Response::HTTP_OK);
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
