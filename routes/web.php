<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [
    'uses' => 'Front\HomeController@index',
    'as' => 'home',
]);

// Auth
Route::group(['prefix' => '/auth', 'namespace' => 'Auth'], function () {
    Route::get('/otp', [
        'uses' => 'OtpController@show',
        'as' => 'auth.otp',
        'middleware' => 'guest',
    ]);
    Route::post('/otp/request', [
        'uses' => 'OtpController@request',
        'as' => 'auth.otp.request',
        'middleware' => ['throttle:3,1', 'guest'],
    ]);
    Route::post('/otp/submit', [
        'uses' => 'OtpController@submit',
        'as' => 'auth.otp.submit',
        'middleware' => ['throttle:3,1', 'guest'],
    ]);
});
