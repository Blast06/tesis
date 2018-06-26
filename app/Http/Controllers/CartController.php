<?php

namespace App\Http\Controllers;

use App\Article;
use App\Events\CartStatus;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * CarController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = auth()->user()->articles;
        $favorites = auth()->user()->favoriteArticle;
        return view('pages.cart', compact('cart', 'favorites'));
    }

    public function countCartArticle()
    {
        return response()->json(['count' => auth()->user()->articles()->sum('quantity')], Response::HTTP_OK);
    }

    public function addToCart(Article $article, $quantity)
    {
        auth()->user()->addArticleToCart($article, $quantity);
        broadcast(new CartStatus(auth()->user()));
        return $this->successResponse(['message' => "Article {$article->name} add to shopping cart"]);
    }

    public function removeToCart(Article $article)
    {
        auth()->user()->removeArticleToCart($article);
        broadcast(new CartStatus(auth()->user()));
        return $this->successResponse(['message' => "Article {$article->name} remove to shopping cart"]);
    }
}
