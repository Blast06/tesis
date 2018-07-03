<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\AuthController@login');
Route::post('signup', 'Api\AuthController@signup');
Route::post('logout', 'Api\AuthController@logout');
Route::post('refresh', 'Api\AuthController@refresh');
Route::post('show', 'Api\AuthController@show');
Route::post('me', 'Api\AuthController@me');

/*
 * Articles
 */
Route::resource('articles','Api\ArticleController')->only('index', 'show','create');

/*
 * Categories
 */
Route::resource('categories','Api\CategoryController')->only('index', 'show');
Route::resource('websites','Api\WebsiteController')->only('index', 'show','store');
Route::resource('users','Api\UserController')->only('index', 'show');


