<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [
    'uses' => 'DashboardController@index',
    'as' => 'dashboard',
]);
