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