<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [
    'uses' => 'DashboardController@index',
    'as' => 'index',
]);

Route::group(['prefix' => '/profile'], function () {
    Route::get('/edit', [
        'uses' => 'ProfileController@edit',
        'as' => 'profile.edit',
    ]);
    Route::post('/', [
        'uses' => 'ProfileController@update',
        'as' => 'profile.update',
    ]);
    Route::post('/image/edit', [
        'uses' => 'ProfileController@updateImage',
        'as' => 'profile.image.update',
    ]);
});

Route::get('/playout', [
    'uses' => 'PlayoutController@index',
    'as' => 'playout.index',
]);


Route::group(['prefix' => '/streams'], function () {
    Route::get('/', [
        'uses' => 'StreamController@index',
        'as' => 'streams.index',
    ]);
    Route::post('/datatable', [
        'uses' => 'StreamController@datatable',
        'as' => 'streams.datatable',
    ]);
    Route::delete('/{stream}', [
        'uses' => 'StreamController@destroy',
        'as' => 'streams.destroy',
    ]);
});

Route::get('/settings', [
    'uses' => 'SettingController@index',
    'as' => 'settings',
]);

Route::group(['middleware' => 'auth.admin'], function () {
    Route::group(['prefix' => '/asset-categories'], function () {
        Route::get('/', [
            'uses' => 'AssetCategoryController@index',
            'as' => 'asset-categories.index',
        ]);
        Route::post('/datatable', [
            'uses' => 'AssetCategoryController@datatable',
            'as' => 'asset-categories.datatable',
        ]);
        Route::get('/create', [
            'uses' => 'AssetCategoryController@create',
            'as' => 'asset-categories.create',
        ]);
        Route::post('/', [
            'uses' => 'AssetCategoryController@store',
            'as' => 'asset-categories.store',
        ]);
        Route::delete('/{category}', [
            'uses' => 'AssetCategoryController@destroy',
            'as' => 'asset-categories.destroy',
        ]);
    });

    Route::group(['prefix' => '/assets'], function () {
        Route::get('/', [
            'uses' => 'AssetController@index',
            'as' => 'assets.index',
        ]);
        Route::post('/datatable', [
            'uses' => 'AssetController@datatable',
            'as' => 'assets.datatable',
        ]);
        Route::get('/create', [
            'uses' => 'AssetController@create',
            'as' => 'assets.create',
        ]);
        Route::post('/', [
            'uses' => 'AssetController@store',
            'as' => 'assets.store',
        ]);
        Route::get('/{asset}/edit', [
            'uses' => 'AssetController@edit',
            'as' => 'assets.edit',
        ]);
        Route::put('/{asset}', [
            'uses' => 'AssetController@update',
            'as' => 'assets.update',
        ]);
        Route::delete('/{asset}', [
            'uses' => 'AssetController@destroy',
            'as' => 'assets.destroy',
        ]);
    });

    Route::group(['prefix' => '/users'], function () {
        Route::get('/', [
            'uses' => 'UserController@index',
            'as' => 'users.index',
        ]);
        Route::post('/datatable', [
            'uses' => 'UserController@datatable',
            'as' => 'users.datatable',
        ]);
        Route::get('/{user}/edit', [
            'uses' => 'UserController@edit',
            'as' => 'users.edit',
        ]);
        Route::put('/{user}', [
            'uses' => 'UserController@update',
            'as' => 'users.update',
        ]);
        Route::delete('/{user}', [
            'uses' => 'UserController@destroy',
            'as' => 'users.destroy',
        ]);
    });

    Route::group(['prefix' => '/admins'], function () {
        Route::get('/', [
            'uses' => 'AdminController@index',
            'as' => 'admins.index',
        ]);
        Route::post('/datatable', [
            'uses' => 'AdminController@datatable',
            'as' => 'admins.datatable',
        ]);
        Route::get('/{admin}/edit', [
            'uses' => 'AdminController@edit',
            'as' => 'admins.edit',
        ]);
        Route::put('/{admin}', [
            'uses' => 'AdminController@update',
            'as' => 'admins.update',
        ]);
        Route::delete('/{admin}', [
            'uses' => 'AdminController@destroy',
            'as' => 'admins.destroy',
        ]);
    });
});
