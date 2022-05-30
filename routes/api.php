<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Currency
    Route::apiResource('currencies', 'CurrencyApiController');

    // Balance
    Route::apiResource('balances', 'BalanceApiController');

    // Hardware Type
    Route::apiResource('hardware-types', 'HardwareTypeApiController');

    // Hardware Item
    Route::post('hardware-items/media', 'HardwareItemApiController@storeMedia')->name('hardware-items.storeMedia');
    Route::apiResource('hardware-items', 'HardwareItemApiController');

    // Contract
    Route::apiResource('contracts', 'ContractApiController');

    // Transaction
    Route::apiResource('transactions', 'TransactionApiController');

    // Contract Period
    Route::apiResource('contract-periods', 'ContractPeriodApiController');

    // User Statistic
    Route::apiResource('user-statistics', 'UserStatisticApiController');

    // Message
    Route::apiResource('messages', 'MessageApiController');

    // Faq
    Route::apiResource('faqs', 'FaqApiController');

    // Setting
    Route::apiResource('settings', 'SettingApiController');

    // Chat
    Route::apiResource('chats', 'ChatApiController');

    // Wallet
    Route::apiResource('wallets', 'WalletApiController');

    // Cart
    Route::apiResource('carts', 'CartApiController');
});
