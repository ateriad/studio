<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [
    'uses' => 'Front\HomeController@index',
    'as' => 'home',
]);
