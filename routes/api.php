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
Route::get('{website}', 'Api\WebsiteController@show')->name('api.websites.show')->fallback();
Route::get('{website}/subscribe', 'Api\WebsiteController@subscribe')->name('api.websites.subscribe')->fallback();
Route::get('{website}/unsubscribe', 'Api\WebsiteController@unsubscribe')->name('api.websites.unsubscribe')->fallback();

// Articles
Route::get('articles/subscribed', 'Api\ArticleController@articleOfMySubscribed');
Route::get('articles/{slug}', 'Api\ArticleController@show')->name('api.articles.show ');
Route::get('{article}/favorite', 'Api\ArticleController@favorite')->name('api.articles.favorite')->fallback();
Route::get('{article}/unfavorite', 'Api\ArticleController@unfavorite')->name('api.articles.unfavorite')->fallback();
/*
 * Client routes
 */
Route::middleware('client')->name('api.')->prefix('client')->group(function () {
    // Article Client
    Route::post('{website}/articles/images', 'Api\ArticleController@images')->name('articles.images');
    Route::resource('{website}/articles', 'Api\ArticleController')->except('show', 'create', 'edit');

    // Website Client
    Route::post('{website}/image', 'Api\WebsiteController@image')->name('websites.image');
    Route::put('{website}/update', 'Api\WebsiteController@update')->name('websites.update');
});
