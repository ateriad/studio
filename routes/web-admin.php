<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [
    'uses' => 'DashboardController@index',
    'as' => 'dashboard',
]);

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
});
