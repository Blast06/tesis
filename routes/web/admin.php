<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
 *  Rediregir al login, al intentar acceder a cualquier url privada sin estar conectado
 */

Route::catch(function (){
    throw new NotFoundHttpException;
});

Route::middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/', 'Admin\DashboardAdminController@index')->name('dashboard');
});

