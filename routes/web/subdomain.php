<?php

Route::get('/', function ($subdomain) {
    return $subdomain;
})->name('subdomin.index');