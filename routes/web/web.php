<?php

/**
 * Login Route
 */
Auth::routes();

Route::get('/login/facebook', 'LoginSocialite\FacebookController@redirectToFacebook')->name('login.facebook');
Route::get('/login/facebook/callback', 'LoginSocialite\FacebookController@handleFacebookCallback')->name('login.facebook.callback');

Route::get('/login/google', 'LoginSocialite\GoogleController@redirectToGoogle')->name('login.google');
Route::get('/login/google/callback', 'LoginSocialite\GoogleController@handleGoogleCallback')->name('login.google.callback');

Route::get('/login/twitter', 'LoginSocialite\TwitterController@redirectToTwitter')->name('login.twitter');
Route::get('/login/twitter/callback', 'LoginSocialite\TwitterController@handleTwitterCallback')->name('login.twitter.callback');

/**
 *  Active account
*/
Route::get('account/activate/{token}', 'Auth\ActivationController@activate')->name('account.activate');
Route::get('account/activation/request', 'Auth\ActivationController@request')->name('account.activation.request')->middleware(['auth']);
Route::post('account/activation/email', 'Auth\ActivationController@changeEmailResend')->name('account.activation.change.email')->middleware(['auth','throttle:0,1']);
Route::post('account/resend/activation', 'Auth\ActivationController@resend')->name('account.activation.resend')->middleware(['auth','throttle:0,1']);

/*
 * Notification
 */
Route::get('notifications', 'Notification\NotificationController@index');
Route::get('notifications/read-all', 'Notification\NotificationController@markAsRead');
Route::get('notifications/count', 'Notification\NotificationController@count');
Route::get('notifications/{notification}', 'Notification\NotificationController@readNotification');

/*
 * Profile
 */
Route::get('profile', 'User\ProfileController@index');
Route::post('profile/change/avatar', 'User\ProfileController@avatar');

/*
 * Others Routes...
 */
Route::get('/', 'MarketingController@index')->name('marketing.index');
Route::get('/home', 'HomeController@index')->name('home.index');

Route::get('/search', function () {
    return view('pages.details');
});

/*
 * Public Website
 */
Route::resource('websites', 'Website\WebsiteController')->only('index', 'create', 'store');
Route::get('{website}', 'Website\WebsiteController@show')->fallback();
Route::post('{website}/subscribe', 'Website\SubcribeController@subscribe')->name('website.subscribe')->fallback();
Route::post('{website}/unsubscribe', 'Website\SubcribeController@unsubscribe')->name('website.unsubscribe')->fallback();