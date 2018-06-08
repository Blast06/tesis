<?php

Route::get('/', 'MarketingController@index')->name('marketing.index');

/**
 * Login Route
 */
Auth::routes();

Route::get('login/facebook', 'LoginSocialiteController@redirectToFacebook')->name('login.facebook');
Route::get('login/facebook/callback', 'LoginSocialiteController@handleFacebookCallback')->name('login.facebook.callback');

Route::get('login/google', 'LoginSocialiteController@redirectToGoogle')->name('login.google');
Route::get('login/google/callback', 'LoginSocialiteController@handleGoogleCallback')->name('login.google.callback');

Route::get('login/twitter', 'LoginSocialiteController@redirectToTwitter')->name('login.twitter');
Route::get('login/twitter/callback', 'LoginSocialiteController@handleTwitterCallback')->name('login.twitter.callback');

/**
 *  Active account
*/
Route::get('activate/{token}', 'Auth\ActivationController@activate')->name('activate.account')->fallback();
Route::get('activate/resend/code', 'Auth\ActivationController@indexResendActivationCode')->name('activate.resend.index');
Route::post('activate/resend/code', 'Auth\ActivationController@resendActivationCode')->name('activate.resend.code')->middleware(['throttle:1,1']);
Route::get('activate/change/email', 'Auth\ActivationController@indexChangeEmail')->name('activate.change.email.index');
Route::post('activate/change/email', 'Auth\ActivationController@changeEmailAndResendActivationCode')->name('activate.change.email')->middleware(['throttle:1,1']);

/*
* Auth User Route
*/
Route::get('home', 'HomeController@index')->name('home.index');
Route::get('profiles', 'ProfileController@index')->name('profiles.index');
Route::post('profiles', 'ProfileController@avatar')->name('profiles.update');
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
Route::get('websites', 'Client\WebsiteController@index')->name('websites.index');
Route::post('websites', 'Client\WebsiteController@store')->name('websites.store');
Route::get('websites/feed', 'Client\WebsiteController@feed')->name('websites.feed');
Route::get('websites/create', 'Client\WebsiteController@create')->name('websites.create');
Route::get('{website}', 'Client\WebsiteController@show')->name('websites.show')->fallback();
Route::get('{website}/unsubscribe', 'Client\WebsiteController@unsubscribe')->name('websites.unsubscribe')->fallback();
Route::get('{website}/subscribe', 'Client\WebsiteController@subscribe')->name('websites.subscribe')->fallback();

/*
 * Public Articles Route
 */
Route::get('articles/{slug}', 'Client\ArticleController@show')->name('articles.show');

/*
 *  Public Chat
 */
Route::get('messages', 'Client\MessageController@index')->name('messages.index');
Route::get('messages/create', 'Client\MessageController@createMessage');
Route::post('messages', 'Client\MessageController@storeUser')->name('messages.store');
Route::get('messages/conversations', 'Client\MessageController@conversationUser');
Route::get('messages/conversations/{conversation}', 'Client\MessageController@showConversation')->name('messages.show.conversation');

/*
 * Recursos API Web
 */
Route::get('web/api/categories', 'CategoryController@categories')->middleware('auth');
