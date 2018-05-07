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

});

