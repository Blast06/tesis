<?php

Route::get('/', 'MarketingController@index')->name('marketing.index');
Route::get('/plans', 'SubscriptionController@plans')->name('subscription.plans');
Route::post('/process_subscription', 'SubscriptionController@processSubscription')->name('subscription.process');
Route::get('/subscription/admin', 'SubscriptionController@admin')->name('subscriptions.admin');
Route::post('/subscription/resume', 'SubscriptionController@resume')->name('subscription.resume');
Route::post('/subscription/cancel', 'SubscriptionController@cancel')->name('subscription.cancel');
Route::post('/subscription/admin', 'SubscriptionController@change')->name('subscription.change');
Route::get('/subscription/invoice', 'SubscriptionController@invoice')->name('subscription.invoice');
Route::get('/{invoice}/download', 'SubscriptionController@invoiceDownload')->name('subscription.invoice.download');

/**
 * Auth Route
 */
Auth::routes();

Route::post('logoutOthers', 'Auth\LogoutOtherController@logoutOtherDevices');

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
Route::get('websites/feed', 'WebsiteController@feed')->name('websites.feed');
Route::resource('websites', 'WebsiteController')->only('index', 'create', 'store');
Route::get('{website}', 'WebsiteController@show')->name('websites.show')->fallback();
Route::get('{website}/subscribe', 'WebsiteController@subscribe')->name('websites.subscribe')->fallback();
Route::get('{website}/unsubscribe', 'WebsiteController@unsubscribe')->name('websites.unsubscribe')->fallback();
Route::get('{website}/information', 'WebsiteController@information')->name('websites.information')->fallback();

/*
 * Public Articles Route
 */
Route::get('articles/{slug}', 'ArticleController@show')->name('articles.show');
Route::get('{article}/favorite', 'ArticleController@favorite')->name('articles.favorite')->fallback();
Route::get('{article}/unfavorite', 'ArticleController@unfavorite')->name('articles.unfavorite')->fallback();

/*
 *  Public Chat
 */
Route::get('messages', 'Client\MessageController@index')->name('messages.index');
Route::get('messages/create', 'Client\MessageController@createMessage');
Route::post('messages', 'Client\MessageController@storeUser')->name('messages.store');
Route::get('messages/conversations', 'Client\MessageController@conversationUser');
Route::get('messages/conversations/{conversation}', 'Client\MessageController@showConversation')->name('messages.show.conversation');

/*
 * Cart
 */
Route::get('shopping/cart', 'CartController@index')->name('cart.index');
Route::get('shopping/cart/count', 'CartController@countCartArticle')->name('cart.count');
Route::get('{article}/add/{quantity}/cart', 'CartController@addToCart')->name('articles.add.cart')->fallback();
Route::get('{article}/remove/cart', 'CartController@removeToCart')->name('articles.remove.cart')->fallback();

/*
 * Reviews
 */
Route::resource('articles.reviews', 'ReviewController')->only(['store', 'update']);

/*
 * Orders
 */
Route::get('orders', 'OrderController@index')->name('orders.index');
Route::post('orders', 'OrderController@store')->name('orders.store');

/*
 * Recursos API Web
 */
Route::get('web/api/categories', 'CategoryController@categories')->middleware('auth');
