<?php

Route::get('dd', function () {
    return dd(\App\Models\Transaction::queueNumber());
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

        // Sales Report
        Route::get('sales_report', [
            'uses' => 'SalesReportController@index',
            'as' => 'sales_report.index'
        ]);
        Route::post('sales_report/daily_sales', [
            'uses' => 'SalesReportController@dailySales',
            'as' => 'sales_report.daily_sales'
        ]);
        Route::post('sales_report/monthly_sales', [
            'uses' => 'SalesReportController@monthlySales',
            'as' => 'sales_report.monthly_sales'
        ]);
        Route::post('sales_report/yearly_sales', [
            'uses' => 'SalesReportController@yearlySales',
            'as' => 'sales_report.yearly_sales'
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
                'uses' => 'MerchandiseController@makeAvailableToday',
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
            Route::resource('merchandise/categories', 'CategoryController', [
                'parameters' => 'singular'
            ]);
        });
    });

    Route::group(['roles' => [cashier(), admin()]], function () {

        // Cashier Dashboard
        Route::get('cashier', [
            'uses' => 'DashboardController@cashier',
            'as' => 'cashier.index'
        ]);
        Route::get('cashier/queue', [
            'uses' => 'CashierController@queue',
            'as' => 'cashier.queue'
        ]);
    });

    Route::group(['roles' => [cardholder(), admin()]], function () {

        // Cardholder Dashboard
        Route::get('cardholder', [
            'uses' => 'DashboardController@cardholder'
        ]);
    });
});

// Orders
Route::resource('transactions.orders', 'OrderController', [
    'parameters' => 'singular'
]);
Route::get('order', [
    'uses' => 'OrderController@order',
    'as' => 'order.order'
]);
Route::post('user_order', [
    'uses' => 'OrderController@userOrder',
    'as' => 'order.user_order'
]);
Route::post('order/send', [
    'uses' => 'OrderController@send',
    'as' => 'order.send'
]);
Route::get('order/menu', [
    'uses' => 'OrderController@menu',
    'as' => 'order.menu'
]);
Route::post('order/load', [
    'uses' => 'OrderController@load',
    'as' => 'order.load'
]);

// Transactions
Route::resource('transactions', 'TransactionController', [
    'parameters' => 'singular'
]);
Route::get('idle', [
    'uses' => 'TransactionController@idle',
    'as' => 'transaction.idle'
]);
Route::post('check_balance', [
    'uses' => 'TransactionController@checkBalance',
    'as' => 'transaction.check_balance'
]);
Route::post('check_card', [
    'uses' => 'TransactionController@checkCard',
    'as' => 'transaction.check_card'
]);
Route::post('auth_card', [
    'uses' => 'TransactionController@authCard',
    'as' => 'transaction.auth_card'
]);
