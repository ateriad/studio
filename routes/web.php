<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [
    'uses' => 'Front\HomeController@index',
    'as' => 'home',
]);

//verify email
Route::get('/account/email/verify/{token}', [
    'uses' => 'Account\EmailResetController@verify',
    'as' => 'account.email.verify',
]);

//upload temp file
Route::post('/upload/file', 'uploadController@upload')->name('upload.temp');

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

    Route::get('/sign-out', [
        'uses' => 'SignOutController@handle',
        'as' => 'auth.sign-out',
    ]);
});
