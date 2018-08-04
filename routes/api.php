<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * Guest or Auth users
 */
Route::get('user', 'Api\UserController@user');

//Websites
Route::post('websites', 'Api\WebsiteController@store')->name('api.websites.store');
Route::get('{website}', 'Api\WebsiteController@show')->name('api.websites.show')->fallback();
Route::get('{website}/subscribe', 'Api\WebsiteController@subscribe')->name('api.websites.subscribe')->fallback();
Route::get('{website}/unsubscribe', 'Api\WebsiteController@unsubscribe')->name('api.websites.unsubscribe')->fallback();
Route::get('{website}/isSubscribedTo', 'Api\WebsiteController@isSubscribedTo')->name('api.websites.isSubscribedTo')->fallback();

// Articles
Route::get('articles/subscribed', 'Api\ArticleController@articleOfMySubscribed');
Route::get('articles/all', 'Api\ArticleController@allArticles');
Route::get('articles/{slug}', 'Api\ArticleController@show')->name('api.articles.show ');
Route::get('{article}/favorite', 'Api\ArticleController@favorite')->name('api.articles.favorite')->fallback();
Route::get('{article}/unfavorite', 'Api\ArticleController@unfavorite')->name('api.articles.unfavorite')->fallback();
Route::get('{article}/isFavoritedTo', 'Api\ArticleController@isFavoritedTo')->name('api.articles.isFavoritedTo')->fallback();
// Cart
Route::get('shopping/cart', 'Api\CartController@index')->name('cart.index');
Route::get('shopping/cart/count', 'Api\CartController@countCartArticle')->name('api.cart.count');
Route::get('{article}/add/{quantity}/cart', 'Api\CartController@addToCart')->name('api.articles.add.cart')->fallback();
Route::get('{article}/remove/cart', 'Api\CartController@removeToCart')->name('api.articles.remove.cart')->fallback();

// Reviews
Route::resource('articles.reviews', 'Api\ReviewController')->only(['store', 'update']);

// Orders
Route::get('orders', 'Api\OrderController@index')->name('api.orders.index');
Route::post('orders', 'Api\OrderController@store')->name('api.orders.store');

/*
 * Client routes
 */
Route::middleware('client')->name('api.')->prefix('client')->group(function () {
    // Article Client
    Route::post('{website}/articles/images', 'Api\Client\ArticleController@images')->name('articles.images');
    Route::resource('{website}/articles', 'Api\Client\ArticleController')->except('show', 'create', 'edit');

    // Website Client
    Route::post('{website}/image', 'Api\Client\WebsiteController@image')->name('websites.image');
    Route::put('{website}/update', 'Api\Client\WebsiteController@update')->name('websites.update');
});
