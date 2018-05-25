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
    Route::put('{website}/update', 'Client\WebsiteController@update')->name('website.update');
    Route::post('{website}/image', 'Client\WebsiteController@image')->name('website.image');

    Route::resource('{website}/articles', 'Client\ArticleController');
});

