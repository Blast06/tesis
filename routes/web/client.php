<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
 *  Rediregir al login, al intentar acceder a cualquier url privada sin estar conectado
 */

Route::catch(function (){
    throw new NotFoundHttpException;
});

Route::middleware(['client'])->group(function () {

    Route::get('{website}/dashboard', 'Dashboard\ClientDashboardController@index')->name('client.dashboard');

    Route::get('{website}/settings', 'Website\WebsiteSettingController@index')->name('client.setting.index');
    Route::put('{website}/settings', 'Website\WebsiteSettingController@update')->name('client.setting.update');
    Route::post('{website}/settings/change/image', 'Website\WebsiteSettingController@image')->name('client.change.image');


});

