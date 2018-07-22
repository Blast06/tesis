<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
 *  Rediregir al login, al intentar acceder a cualquier url privada sin estar conectado
 */

Route::catch(function (){
    throw new NotFoundHttpException;
});

Route::middleware(['client'])->prefix('{website}')->name('client.')->group(function () {

    Route::get('dashboard', 'Client\DashboardClientController@index')->name('dashboard');

    Route::get('edit', 'Client\WebsiteController@edit')->name('websites.edit');
    Route::put('update', 'Client\WebsiteController@update')->name('websites.update');
    Route::post('image', 'Client\WebsiteController@image')->name('websites.image');

    Route::post('articles/images', 'Client\ArticleController@images')->name('article.image');
    Route::resource('articles', 'Client\ArticleController')->except('show');

    Route::get('messages', 'Client\MessageController@index')->name('message');
    Route::post('messages', 'Client\MessageController@storeWebsite')->name('message.store');
    Route::get('messages/conversations', 'Client\MessageController@conversationWebsite')->name('message.conversation');

    Route::delete('medias/{media}', 'Client\MediaController@destroy')->name('media.destroy');

    Route::get('orders', 'Client\OrderController@index')->name('orders.index');
    Route::get('orders/{order}', 'Client\OrderController@edit')->name('orders.edit');
    Route::put('orders/{order}', 'Client\OrderController@update')->name('orders.update');
});

