<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('dd', function () {

    return dd(json_decode('', true));
});

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@home');
Route::get('faq', 'HomeController@faq');

Route::group(['middleware' => 'roles'], function () {
    $admin = config('static.roles')[0]['id'];
    $cashier = config('static.roles')[1]['id'];
    $cardholder = config('static.roles')[2]['id'];

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
