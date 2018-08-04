<?php

namespace App\Http\Controllers\Client;

use App\{Website, Article};
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\DataTables\ClientArticleDataTable;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\{CreateArticleRequest, UpdateArticleRequest, UploadImageArticleRequest};

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
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
     * Display a listing of the resource.
     *
     * @param \App\DataTables\ClientArticleDataTable $dataTable
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(ClientArticleDataTable $dataTable, Website $website)
    {
        $header = "Todas los articulos de {$website->name}". $this->buttonsFilter();
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
     * Show the form for editing the specified resource.
     *
     * @param \App\Website $website
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Website $website, Article $article)
    {
        abort_unless($article->isRegisteredIn($website), 404);
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
        abort_unless($article->isRegisteredIn($website), 404);
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
        abort_unless($article->isRegisteredIn($website), 404);
        $article->delete();
        if (request()->ajax()) { return $this->showOne($article, Response::HTTP_OK); }
        return redirect()->route('client.articles.index', $website);
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
     * @return string
     */
    public function buttonsFilter()
    {
        return "<form class=\"form-inline float-right\" method=\"get\">
                  <div class=\"form-group\">
                    <select class=\"form-control\" name=\"status\">
                      <option value=\"TODOS\">Todos</option>
                      <option value=\"NO_DISPONIBLE\">No disponible</option>
                      <option value=\"DISPONIBLE\">Disponible</option>
                      <option value=\"PRIVADO\">Privado</option>
                    </select>
                  </div>
                  <button type=\"submit\" class=\"btn btn-primary ml-2\">Filtrar</button>
                </form>";
    }
}
