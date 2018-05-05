<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
 *  Rediregir al login, al intentar acceder a cualquier url privada sin estar conectado
 */

Route::catch(function (){
    throw new NotFoundHttpException;
});


Route::get('/', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');