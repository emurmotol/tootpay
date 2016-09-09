<?php

Route::get('dd', function () {
//    $transactions = \App\Models\User::find('12312312312')->transactions()->where('status_response_id', 11)->get();
//
//    $_transactions = collect();
//    $_orders = collect();
//
//    foreach ($transactions as $transaction) {
//        $_transactions->push($transaction);
//
//        foreach ($transaction->orders()->get() as $order) {
//            $_orders->push($order);
//        }
//    }
//
//    return dd($_orders->toArray());
//    return dd($_transactions->toArray());

    return dd(\App\Models\TootCard::expired()->get());
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

        // Settings
        Route::get('settings/toot_card', [
            'uses' => 'SettingController@tootCard',
            'as' => 'settings.toot_card'
        ]);
        Route::put('settings/update_toot_card', [
            'uses' => 'SettingController@updateTootCard',
            'as' => 'settings.update_toot_card'
        ]);
        Route::get('settings/operation_day', [
            'uses' => 'SettingController@operationDay',
            'as' => 'settings.operation_day'
        ]);
        Route::put('settings/update_operation_day', [
            'uses' => 'SettingController@updateOperationDay',
            'as' => 'settings.update_operation_day'
        ]);

        // Sales Report
        Route::get('sales_report', [
            'uses' => 'SalesReportController@index',
            'as' => 'sales_report.index'
        ]);
        Route::post('sales_report/daily', [
            'uses' => 'SalesReportController@daily',
            'as' => 'sales_report.daily'
        ]);
        Route::post('sales_report/monthly', [
            'uses' => 'SalesReportController@monthly',
            'as' => 'sales_report.monthly'
        ]);
        Route::post('sales_report/yearly', [
            'uses' => 'SalesReportController@yearly',
            'as' => 'sales_report.yearly'
        ]);
        Route::post('sales_report/export/daily', [
            'uses' => 'SalesReportController@exportDaily',
            'as' => 'sales_report.export_daily'
        ]);
        Route::post('sales_report/export/monthly', [
            'uses' => 'SalesReportController@exportMonthly',
            'as' => 'sales_report.export_monthly'
        ]);
        Route::post('sales_report/export/yearly', [
            'uses' => 'SalesReportController@exportYearly',
            'as' => 'sales_report.export_yearly'
        ]);
        Route::get('sales_report/download/daily/{file_name}', 'SalesReportController@downloadDaily');
        Route::get('sales_report/download/monthly/{file_name}', 'SalesReportController@downloadMonthly');
        Route::get('sales_report/download/yearly/{file_name}', 'SalesReportController@downloadYearly');

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
        Route::get('users/admin', [
            'uses' => 'UserController@admin',
            'as' => 'users.admin'
        ]);
        Route::get('users/cashier', [
            'uses' => 'UserController@cashier',
            'as' => 'users.cashier'
        ]);
        Route::get('users/cardholder', [
            'uses' => 'UserController@cardholder',
            'as' => 'users.cardholder'
        ]);
        Route::get('users/guest', [
            'uses' => 'UserController@guest',
            'as' => 'users.guest'
        ]);

        // Toot Cards
        Route::resource('toot_cards', 'TootCardController', [
            'parameters' => 'singular'
        ]);
        Route::get('toot_cards/active', [
            'uses' => 'TootCardController@active',
            'as' => 'toot_cards.active'
        ]);
        Route::get('toot_cards/inactive', [
            'uses' => 'TootCardController@inactive',
            'as' => 'toot_cards.inactive'
        ]);
        Route::get('toot_cards/expired', [
            'uses' => 'TootCardController@expired',
            'as' => 'toot_cards.expired'
        ]);
        Route::get('toot_cards/not_associated', [
            'uses' => 'TootCardController@notAssociated',
            'as' => 'toot_cards.not_associated'
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
        Route::get('transactions/count', [
            'uses' => 'CashierController@transactionsCount',
            'as' => 'cashier.transactions_count'
        ]);
        Route::get('transactions/cashier', [
            'uses' => 'CashierController@transactionsCashier',
            'as' => 'cashier.transactions_cashier'
        ]);
        Route::post('transaction/done', [
            'uses' => 'CashierController@transactionDone',
            'as' => 'cashier.transaction_done'
        ]);
        Route::post('transaction/cancel', [
            'uses' => 'CashierController@transactionCancel',
            'as' => 'cashier.transaction_cancel'
        ]);
        Route::post('transaction/create_card_holder', [
            'uses' => 'CashierController@transactionCreateCardHolder',
            'as' => 'cashier.transaction_create_card_holder'
        ]);
    });

    Route::group(['roles' => [cardholder(), admin()]], function () {

        // Cardholder Dashboard
        Route::get('cardholder', [
            'uses' => 'DashboardController@cardholder'
        ]);
        Route::get('{user}', [
            'uses' => 'UserController@profile',
            'as' => 'users.profile_index'
        ]);
        Route::get('{user}/edit', [
            'uses' => 'UserController@profileEdit',
            'as' => 'users.profile_edit'
        ]);
        Route::put('{user}', [
            'uses' => 'UserController@profileUpdate',
            'as' => 'users.profile_update'
        ]);
        Route::put('{user}/password', [
            'uses' => 'UserController@profileUpdatePassword',
            'as' => 'users.profile_update_password'
        ]);
        Route::get('{user}/toot_card', [
            'uses' => 'UserController@tootCard',
            'as' => 'users.toot_card'
        ]);
        Route::get('{user}/toot_card/pin_code', [
            'uses' => 'UserController@tootCardEditPinCode',
            'as' => 'users.toot_card_edit_pin_code'
        ]);
        Route::put('{user}/toot_card/pin_code', [
            'uses' => 'UserController@tootCardUpdatePinCode',
            'as' => 'users.toot_card_update_pin_code'
        ]);
        Route::get('{user}/order_history', [
            'uses' => 'UserController@orderHistory',
            'as' => 'users.order_history'
        ]);
        Route::get('{user}/reload_history', [
            'uses' => 'UserController@reloadHistory',
            'as' => 'users.reload_history'
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
Route::post('check_user_id', [
    'uses' => 'TransactionController@checkUserId',
    'as' => 'transaction.check_user_id'
]);
Route::post('auth_card', [
    'uses' => 'TransactionController@authCard',
    'as' => 'transaction.auth_card'
]);
Route::post('reload_request', [
    'uses' => 'TransactionController@reloadRequest',
    'as' => 'transaction.reload_request'
]);
Route::post('share_load', [
    'uses' => 'TransactionController@shareLoad',
    'as' => 'transaction.share_load'
]);
