<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
 *  Rediregir al login, al intentar acceder a cualquier url privada sin estar conectado
 */

Route::catch(function (){
    throw new NotFoundHttpException;
});

Route::middleware(['client'])->group(function () {

    Route::get('{website}/dashboard', 'Client\DashboardClientController@index')->name('client.dashboard');

    Route::get('{website}/edit', 'Client\WebsiteController@edit')->name('websites.edit');
    Route::put('{website}/update', 'Client\WebsiteController@update')->name('websites.update');
    Route::post('{website}/image', 'Client\WebsiteController@image')->name('websites.image');

    Route::post('{website}/articles/images', 'Client\ArticleController@images');
    Route::resource('{website}/articles', 'Client\ArticleController')->except('show');

    Route::get('{website}/messages', 'Client\MessageController@index');
    Route::post('{website}/messages', 'Client\MessageController@storeWebsite');
    Route::get('{website}/messages/conversations', 'Client\MessageController@conversationWebsite');
});

