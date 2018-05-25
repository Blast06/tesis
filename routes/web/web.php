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

/*
* Auth User Route
*/
Route::get('/home', 'HomeController@index')->name('home.index');
Route::get('profiles', 'ProfileController@index')->name('profiles.index');
Route::post('profiles/avatar', 'ProfileController@avatar')->name('profiles.avatar');
/*
 * Notification
 */
Route::get('notifications', 'NotificationController@index');
Route::get('notifications/read-all', 'NotificationController@markAsRead');
Route::get('notifications/count', 'NotificationController@count');
Route::get('notifications/{notification}', 'NotificationController@readNotification');

/*
 * Search
 */
Route::get('search', 'HomeController@search');

/*
 * Public Website Route
 */
Route::get('websites', 'PublicWebsiteController@index')->name('websites.index');
Route::get('websites/create', 'PublicWebsiteController@create')->name('websites.create');
Route::post('websites', 'PublicWebsiteController@store')->name('websites.store');
Route::get('{website}', 'PublicWebsiteController@show')->name('website.show')->fallback();
Route::post('{website}/unsubscribe', 'PublicWebsiteController@unsubscribe')->name('website.unsubscribe')->fallback();
Route::post('{website}/subscribe', 'PublicWebsiteController@subscribe')->name('website.subscribe')->fallback();

/*
 * Recursos API Web
 */
Route::get('web/api/categories', 'ApiCategoryController@categories')->middleware('auth');