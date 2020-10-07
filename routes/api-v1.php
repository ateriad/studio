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
    Route::group(['prefix' => '/asset-categories'], function () {
        Route::get('/', 'AssetCategory\AssetCategoryController@index');

        //assets of a category
        Route::get('/{category}/assets', 'AssetCategory\AssetController@index');
    });

    Route::group(['prefix' => '/assets'], function () {
        Route::get('/', 'Asset\AssetController@index');
    });
});


