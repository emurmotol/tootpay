<?php

Route::get('dd', function () {
//    $user = \App\Models\User::find('00420130023');
//    $toot_card = $user->tootCards()->first()->id;

//    $toot_card = \App\Models\TootCard::find('6011983972698196');
//    $user = $toot_card->users()->first()->id;
//
//    return dd(\App\Models\Merchandise::find(1)->tootCards()->save($toot_card, [
//        'user_id' => $user,
//        'quantity' => 12,
//        'total' => 123,
//    ]));

//    return dd(\App\Models\User::find('00420130023'));//->with('merchandises', 'tootcards')->get());
//    return dd(\App\Models\TootCard::find('6011983972698196')->users()->getRelatedIds());

    return dd(slideIdle());
});

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@home');
Route::get('faq', 'HomeController@faq');

Route::group(['middleware' => 'roles'], function () {

    Route::group(['roles' => [admin()]], function () {

        // Administrator Dashboard
        Route::get('admin', [
            'uses' => 'DashboardController@admin'
        ]);

        // Users
        Route::post('users/{user}/remove_card/{toot_card}', [
            'uses' => 'UserController@remove_card',
            'as' => 'users.remove_card'
        ]);
        Route::post('users/{user}/attach_card', [
            'uses' => 'UserController@associate_card',
            'as' => 'users.associate_card'
        ]);
        Route::resource('users', 'UserController', [
            'parameters' => 'singular'
        ]);

        // Toot Cards
        Route::resource('toot_cards', 'TootCardController', [
            'parameters' => 'singular'
        ]);

        Route::group(['namespace' => 'Merchandise'], function() {

            // Merchandises
            Route::put('merchandises/available/{merchandise}', [
                'uses' => 'MerchandiseController@available',
                'as' => 'merchandises.available.update'
            ]);
            Route::get('merchandises/available', [
                'uses' => 'MerchandiseController@showAvailable',
                'as' => 'merchandises.available.index'
            ]);
            Route::get('merchandises/unavailable', [
                'uses' => 'MerchandiseController@showUnavailable',
                'as' => 'merchandises.unavailable.index'
            ]);
            Route::get('merchandises/daily_menu', [
                'uses' => 'MerchandiseController@showMenu',
                'as' => 'merchandises.daily_menu.index'
            ]);
            Route::resource('merchandises', 'MerchandiseController', [
                'parameters' => 'singular'
            ]);

            // Merchandise Category
            Route::resource('merchandise/categories', 'MerchandiseCategoryController', [
                'parameters' => 'singular'
            ]);
        });
    });

    Route::group(['roles' => [cashier(), admin()]], function () {

        // Cashier Dashboard
        Route::get('cashier', [
            'uses' => 'DashboardController@cashier'
        ]);
    });

    Route::group(['roles' => [cardholder(), admin()]], function () {

        // Cardholder Dashboard
        Route::get('cardholder', [
            'uses' => 'DashboardController@cardholder'
        ]);
    });
});

// Client
Route::get('client', [
    'uses' => 'ClientController@index',
    'as' => 'client.index'
]);
Route::get('client/idle', [
    'uses' => 'ClientController@idle',
    'as' => 'client.idle'
]);
Route::get('client/guest', [
    'uses' => 'ClientController@guest',
    'as' => 'client.guest'
]);
Route::post('client/check_toot_card', [
    'uses' => 'ClientController@checkTootCard',
    'as' => 'client.check_toot_card'
]);
Route::post('client/auth_toot_card', [
    'uses' => 'ClientController@authTootCard',
    'as' => 'client.auth_toot_card'
]);
Route::get('client/order', [
    'uses' => 'ClientController@order',
    'as' => 'client.order'
]);
Route::post('client/todays_menu', [
    'uses' => 'ClientController@todaysMenu',
    'as' => 'client.todays_menu'
]);
