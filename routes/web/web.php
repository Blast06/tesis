<?php

Route::get('/', 'MarketingController@index')->name('marketing.index');

/**
 * Login Route
 */
Auth::routes();

Route::get('/login/facebook', 'LoginSocialiteController@redirectToFacebook')->name('login.facebook');
Route::get('/login/facebook/callback', 'LoginSocialiteController@handleFacebookCallback')->name('login.facebook.callback');

Route::get('/login/google', 'LoginSocialiteController@redirectToGoogle')->name('login.google');
Route::get('/login/google/callback', 'LoginSocialiteController@handleGoogleCallback')->name('login.google.callback');

Route::get('/login/twitter', 'LoginSocialiteController@redirectToTwitter')->name('login.twitter');
Route::get('/login/twitter/callback', 'LoginSocialiteController@handleTwitterCallback')->name('login.twitter.callback');

/**
 *  Active account
*/
Route::get('account/activate/{token}', 'Auth\ActivationController@activate')->name('account.activate');
Route::get('account/activation/request', 'Auth\ActivationController@request')->name('account.activation.request')->middleware(['auth']);
Route::post('account/activation/email', 'Auth\ActivationController@changeEmailResend')->name('account.activation.change.email')->middleware(['auth','throttle:0,1']);
Route::post('account/resend/activation', 'Auth\ActivationController@resend')->name('account.activation.resend')->middleware(['auth','throttle:0,1']);

Route::get('/search', function () {
    return view('pages.details');
});

Route::middleware('auth')->group(function () {
    /*
     * Auth User Route
     */
    Route::get('/home', 'HomeController@index')->name('home.index');
    Route::get('profiles', 'ProfileController@index')->name('profiles.index');

    /*
     * Notification
     */
    Route::get('notifications', 'NotificationController@index');
    Route::get('notifications/read-all', 'NotificationController@markAsRead');
    Route::get('notifications/count', 'NotificationController@count');
    Route::get('notifications/{notification}', 'NotificationController@readNotification');
});

/*
 * Public Website Route
 */
Route::get('websites', 'WebsiteController@index')->name('websites.index');
Route::get('websites/create', 'WebsiteController@create')->name('websites.create');
Route::get('{website}', 'WebsiteController@show')->name('website.show')->fallback();

/*
 * Api Web
 */
Route::prefix('v1')->middleware('auth')->group(function () {
    Route::post('user/avatar', 'API\V1\Web\UserController@avatar');

    Route::post('websites', 'API\V1\Web\WebsiteController@store');
    Route::put('{website}/update', 'API\V1\Web\WebsiteController@update')->name('website.update')->middleware('client')->fallback();
    Route::post('{website}/subscribe', 'API\V1\Web\WebsiteController@subscribe')->name('website.subscribe')->fallback();
    Route::post('{website}/unsubscribe', 'API\V1\Web\WebsiteController@unsubscribe')->name('website.unsubscribe')->fallback();
    Route::post('{website}/image', 'API\V1\Web\WebsiteController@image')->name('client.change.image')->middleware('client')->fallback();
});