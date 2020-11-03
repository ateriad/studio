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
});
