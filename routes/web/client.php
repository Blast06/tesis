<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
 *  Rediregir al login, al intentar acceder a cualquier url privada sin estar conectado
 */

Route::catch(function (){
    throw new NotFoundHttpException;
});

Route::middleware(['client'])->group(function () {

    Route::get('{website}/dashboard', 'DashboardClientController@index')->name('client.dashboard');
    Route::get('{website}/edit', 'WebsiteController@edit')->name('websites.edit');
    Route::put('{website}/update', 'WebsiteController@update')->name('website.update');
    Route::post('{website}/image', 'WebsiteController@image')->name('website.image');

    Route::resource('{website}/products', 'ProductController');
});

