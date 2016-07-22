<?php

Route::get('dd', function () {
    return dd(bcrypt('123qwe'));
});

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@home');
Route::get('faq', 'HomeController@faq');

Route::group(['middleware' => 'roles'], function () {
    $admin = \App\Models\Role::json(0);
    $cashier = \App\Models\Role::json(1);
    $cardholder = \App\Models\Role::json(2);

    Route::put('merchandises/available/{merchandise_id}', [
        'uses' => 'MerchandiseController@available',
        'as' => 'merchandises.available',
        'roles' => [$admin]
    ]);
    Route::get('merchandises/available', [
        'uses' => 'MerchandiseController@showAvailable',
        'roles' => [$admin]
    ]);
    Route::get('merchandises/unavailable', [
        'uses' => 'MerchandiseController@showUnavailable',
        'roles' => [$admin]
    ]);
    Route::resource('merchandises', 'MerchandiseController', [
        'parameters' => 'singular',
        'roles' => [$admin]
    ]);

    Route::resource('categories', 'MerchandiseCategoryController', [
        'parameters' => 'singular',
        'roles' => [$admin]
    ]);

    Route::get('cashier', [
        'uses' => 'DashboardController@cashier',
        'roles' => [$cashier, $admin]
    ]);
    Route::get('admin', [
        'uses' => 'DashboardController@admin',
        'roles' => [$admin]
    ]);
    Route::get('cardholder', [
        'uses' => 'DashboardController@cardholder',
        'roles' => [$cardholder, $admin]
    ]);
    Route::get('client', [
        'uses' => 'DashboardController@client',
        'roles' => [$admin, $cashier]
    ]);
});
