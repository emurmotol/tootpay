<?php

Route::get('dd', function () {
    return dd(\App\Models\TootCard::userId('4556292070876860'));
});

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@home');
Route::get('faq', 'HomeController@faq');

Route::group(['middleware' => 'roles'], function () {
    $admin = \App\Models\Role::json(0);
    $cashier = \App\Models\Role::json(1);
    $cardholder = \App\Models\Role::json(2);

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
