<?php

// Auth
Route::group(['prefix' => '/auth'], function () {
    // OTP
    Route::group(['prefix' => '/otp'], function () {
        Route::post('/request', 'Auth\OtpController@request')->middleware('throttle:2,1');
        Route::post('/submit', 'Auth\OtpController@submit')->middleware('throttle:5,1');
    });
});

Route::group(['middleware' => 'auth.api'], function () {

});


