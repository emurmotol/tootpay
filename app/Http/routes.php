<?php

Route::get('dd', function () {
    return dd(\App\Models\MerchandiseCategory::withNumberOfEntries()->get());
});

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@home');
Route::get('faq', 'HomeController@faq');

Route::group(['middleware' => 'roles'], function () {

    Route::group(['namespace' => 'Merchandise'], function() {

        // Merchandises
        Route::put('merchandises/available/{merchandise_id}', [
            'uses' => 'MerchandiseController@available',
            'as' => 'merchandises.available',
            'roles' => [admin()]
        ]);
        Route::get('merchandises/available', [
            'uses' => 'MerchandiseController@showAvailable',
            'roles' => [admin()]
        ]);
        Route::get('merchandises/unavailable', [
            'uses' => 'MerchandiseController@showUnavailable',
            'roles' => [admin()]
        ]);
        Route::resource('merchandises', 'MerchandiseController', [
            'parameters' => 'singular',
            'roles' => [admin()]
        ]);

        // Merchandise Category
        Route::resource('merchandises/categories', 'MerchandiseCategoryController', [
            'parameters' => 'singular',
            'roles' => [admin()]
        ]);
    });

    // Dashboard
    Route::get('cashier', [
        'uses' => 'DashboardController@cashier',
        'roles' => [cashier(), admin()]
    ]);
    Route::get('admin', [
        'uses' => 'DashboardController@admin',
        'roles' => [admin()]
    ]);
    Route::get('cardholder', [
        'uses' => 'DashboardController@cardholder',
        'roles' => [cardholder(), admin()]
    ]);
    Route::get('client', [
        'uses' => 'DashboardController@client',
        'roles' => [cashier(), admin()]
    ]);
});
