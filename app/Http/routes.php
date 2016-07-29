<?php

Route::get('dd', function () {
});

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@home');
Route::get('faq', 'HomeController@faq');

Route::group(['middleware' => 'roles'], function () {

    // Toot Cards
    Route::resource('toot_cards', 'TootCardController', [
        'parameters' => 'singular',
        'roles' => [admin()]
    ]);

    Route::group(['namespace' => 'User'], function() {

        // Users
        Route::post('users/{user}/remove_card/{toot_card}', [
            'uses' => 'UserController@remove_card',
            'as' => 'users.remove_card',
            'roles' => [admin()]
        ]);

        Route::resource('users', 'UserController', [
            'parameters' => 'singular',
            'roles' => [admin()]
        ]);
    });

    Route::group(['namespace' => 'Merchandise'], function() {

        // Merchandises
        Route::put('merchandises/available/{merchandise}', [
            'uses' => 'MerchandiseController@available',
            'as' => 'merchandises.available.update',
            'roles' => [admin()]
        ]);
        Route::get('merchandises/available', [
            'uses' => 'MerchandiseController@showAvailable',
            'as' => 'merchandises.available.index',
            'roles' => [admin()]
        ]);
        Route::get('merchandises/unavailable', [
            'uses' => 'MerchandiseController@showUnavailable',
            'as' => 'merchandises.unavailable.index',
            'roles' => [admin()]
        ]);
        Route::get('merchandises/daily_menu', [
            'uses' => 'MerchandiseController@showMenu',
            'as' => 'merchandises.daily_menu.index',
            'roles' => [admin()]
        ]);
        Route::resource('merchandises', 'MerchandiseController', [
            'parameters' => 'singular',
            'roles' => [admin()]
        ]);

        // Merchandise Category
        Route::resource('merchandise/categories', 'MerchandiseCategoryController', [
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
