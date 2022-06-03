<?php

use Illuminate\Support\Facades\Auth;
use App\Notifications\VerifyUserNotification;

Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect'])->group(function () {
    Route::get('/', 'WelcomeController@index')->name('welcome');
    Route::view('/affiliate', 'static.affiliate');
    // Route::view('/privacy', 'static.privacy');
    // Route::view('/refund', 'static.refund');
    //Route::view('/terms', 'static.terms');

    Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
    Auth::routes();

    Route::group(['as' => 'newfront.', 'namespace' => 'Newfront'], function () {


        Route::get('/faq', 'FaqController@index');
        Route::get('/contact', 'ContactController@index')->name('contact');
        Route::post('/contact', 'ContactController@contactPost')->name('contactPost');
        Route::post('/chat-init', 'ChatController@chat_init');
        Route::post('/chat', 'ChatController@ajaxRequestPost');
        Route::get('/about', 'AboutController@index');

        Route::group(['middleware' => ['auth']], function() {

            Route::post('/verify-email', function() {
                $user = Auth::user();
                if( ! $user->verified ) {
                    $user->notify(new VerifyUserNotification($user));

                    return redirect()->route('newfront.profile')->with('message', trans('dashboard._check_email'));
                } else {
                    return redirect()->route('newfront.profile')->with('message', trans('dashboard._mail_alredy_verif'));
                }
            });

            Route::group(['middleware' => ['operator']], function() {
                Route::get('/operator', 'OperatorController@index');
                Route::get('/chatoperator', 'ChatController@ajaxOperatorRequestView');
                Route::post('/chatoperator', 'ChatController@ajaxOperatorRequestPost');
            });

            Route::group(['middleware' => ['redirect.operator']], function() {
                Route::post('/payment-checkout', 'CheckoutController@paymentCheckout')->name('payment_checkout');
                Route::post('transaction-verification', 'CheckoutController@transactionVerification')->name('transaction_verification');

                Route::get('/chat', 'ChatController@index');
                Route::get('/cart', 'CartController@index')->name('cart');
                Route::get('/checkout', 'CheckoutController@index')->name('checkout');
                Route::post('/addtocart', 'CartController@add')->name('cart.add');

                //checkoutClud
                Route::post('/delfromcart', 'CartController@del')->name('cart.del');
                Route::post('/checkout', 'CartController@checkout')->name('cart.checkout');
                Route::post('/cancel', 'CartController@cancel')->name('cart.cancel');
                Route::post('/payed', 'CartController@payed')->name('cart.payed');
                Route::get('/my/{id}', 'HardwareItemController@my');
                Route::get('/miners/{vendor}/{slug}', 'HardwareItemController@show');
                Route::get('/dashboard', 'HomeController@index')->name('dashboard');
                Route::get('/farm', 'FarmController@index')->name('farm');

                Route::group(['middleware' => ['redirect.not_verified']], function() {
                    Route::get('/withdraw', 'WithdrawController@index')->name('withdraw');
                    Route::post('/withdraw', 'WithdrawController@post')->name('withdraw.post');
                });

                Route::get('/withdraw-history', 'WithdrawController@history')->name('withdraw.hisory');
                Route::get('/my-affiliate', 'AffiliateController@index')->name('affiliate');
                Route::get('/support', 'SupportController@index')->name('support');
                Route::get('/profile', 'ProfileController@index')->name('profile');
                Route::post('/profile', 'ProfileController@update')->name('profile.update');
                Route::post('profile/media', 'ProfileController@storeMedia')->name('profile.storeMedia');

                //Route::post('/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
                //Route::post('/profile/password', 'ProfileController@password')->name('profile.password');
            });
        });
    });

    Route::group(['as' => 'blog.', 'namespace' => 'Blog'], function() {
        Route::get('blog/{category}/{slug}', 'BlogController@index');
        Route::get('blog/{category}', 'BlogController@category');
    });


    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
        // Change password
        if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
            Route::group(['middleware' => ['auth', 'admin']], function () {
                Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
            });
            Route::post('password', 'ChangePasswordController@update')->name('password.update');
            Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
            Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        }
    });

});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Currency
    Route::delete('currencies/destroy', 'CurrencyController@massDestroy')->name('currencies.massDestroy');
    Route::resource('currencies', 'CurrencyController');

    // Balance
    Route::delete('balances/destroy', 'BalanceController@massDestroy')->name('balances.massDestroy');
    Route::resource('balances', 'BalanceController');

    // Hardware Type
    Route::delete('hardware-types/destroy', 'HardwareTypeController@massDestroy')->name('hardware-types.massDestroy');
    Route::resource('hardware-types', 'HardwareTypeController');

    // Hardware Item
    Route::delete('hardware-items/destroy', 'HardwareItemController@massDestroy')->name('hardware-items.massDestroy');
    Route::post('hardware-items/media', 'HardwareItemController@storeMedia')->name('hardware-items.storeMedia');
    Route::post('hardware-items/ckmedia', 'HardwareItemController@storeCKEditorImages')->name('hardware-items.storeCKEditorImages');
    Route::resource('hardware-items', 'HardwareItemController');

    // Contract
    Route::delete('contracts/destroy', 'ContractController@massDestroy')->name('contracts.massDestroy');
    Route::resource('contracts', 'ContractController');

    // Transaction
    Route::delete('transactions/destroy', 'TransactionController@massDestroy')->name('transactions.massDestroy');
    Route::resource('transactions', 'TransactionController');

    // Contract Period
    Route::delete('contract-periods/destroy', 'ContractPeriodController@massDestroy')->name('contract-periods.massDestroy');
    Route::resource('contract-periods', 'ContractPeriodController');

    // User Statistic
    Route::delete('user-statistics/destroy', 'UserStatisticController@massDestroy')->name('user-statistics.massDestroy');
    Route::resource('user-statistics', 'UserStatisticController');

    // Message
    Route::delete('messages/destroy', 'MessageController@massDestroy')->name('messages.massDestroy');
    Route::resource('messages', 'MessageController');

    // Faq Category
    Route::delete('faq-categories/destroy', 'FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'FaqCategoryController');

    // Faq
    Route::delete('faqs/destroy', 'FaqController@massDestroy')->name('faqs.massDestroy');
    Route::resource('faqs', 'FaqController');

    // Review
    Route::delete('reviews/destroy', 'ReviewController@massDestroy')->name('reviews.massDestroy');
    Route::resource('reviews', 'ReviewController');

    // Setting
    Route::delete('settings/destroy', 'SettingController@massDestroy')->name('settings.massDestroy');
    Route::resource('settings', 'SettingController');

    // Contact
    Route::delete('contacts/destroy', 'ContactController@massDestroy')->name('contacts.massDestroy');
    Route::resource('contacts', 'ContactController');

    // Chat
    Route::delete('chats/destroy', 'ChatController@massDestroy')->name('chats.massDestroy');
    Route::resource('chats', 'ChatController');

    // Withdrawl
    Route::delete('withdrawls/destroy', 'WithdrawlController@massDestroy')->name('withdrawls.massDestroy');
    Route::resource('withdrawls', 'WithdrawlController');

    // Wallet
    Route::delete('wallets/destroy', 'WalletController@massDestroy')->name('wallets.massDestroy');
    Route::post('wallets/parse-csv-import', 'WalletController@parseCsvImport')->name('wallets.parseCsvImport');
    Route::post('wallets/process-csv-import', 'WalletController@processCsvImport')->name('wallets.processCsvImport');
    Route::resource('wallets', 'WalletController');


    // Wallet Network
    Route::delete('wallet-networks/destroy', 'WalletNetworkController@massDestroy')->name('wallet-networks.massDestroy');
    Route::resource('wallet-networks', 'WalletNetworkController');

    // Category
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoryController');

    // Article
    Route::delete('articles/destroy', 'ArticleController@massDestroy')->name('articles.massDestroy');
    Route::post('articles/media', 'ArticleController@storeMedia')->name('articles.storeMedia');
    Route::post('articles/ckmedia', 'ArticleController@storeCKEditorImages')->name('articles.storeCKEditorImages');
    Route::resource('articles', 'ArticleController');

    // Language
    Route::delete('languages/destroy', 'LanguageController@massDestroy')->name('languages.massDestroy');
    Route::resource('languages', 'LanguageController');

    // About Page
    Route::delete('about-page/destroy', 'AboutPageController@massDestroy')->name('about-page.massDestroy');
    Route::post('about-page/media', 'AboutPageController@storeMedia')->name('about-page.storeMedia');
    Route::post('about-page/ckmedia', 'AboutPageController@storeCKEditorImages')->name('about-page.storeCKEditorImages');
    Route::resource('about-page', 'AboutPageController');

    // Content Page
    Route::delete('content-pages/destroy', 'ContentPageController@massDestroy')->name('content-pages.massDestroy');
    Route::post('content-pages/media', 'ContentPageController@storeMedia')->name('content-pages.storeMedia');
    Route::post('content-pages/ckmedia', 'ContentPageController@storeCKEditorImages')->name('content-pages.storeCKEditorImages');
    Route::resource('content-pages', 'ContentPageController');

    // Cart
     Route::delete('carts/destroy', 'CartController@massDestroy')->name('carts.massDestroy');
     Route::get('carts/unpaid', 'CartController@unpaid')->name('carts.unpaid');
     Route::resource('carts', 'CartController');

    // Checkout
    Route::delete('checkouts/destroy', 'CheckoutController@massDestroy')->name('checkouts.massDestroy');
    Route::resource('checkouts', 'CheckoutController');
    Route::post('checkouts/aprove/{id}', 'CheckoutController@aprove')->name('checkouts.aprove');

    Route::resource('page', 'PageController');

    // Mail
    Route::delete('mails/destroy', 'MailController@massDestroy')->name('mails.massDestroy');
    Route::post('mails/media', 'MailController@storeMedia')->name('mails.storeMedia');
    Route::post('mails/ckmedia', 'MailController@storeCKEditorImages')->name('mails.storeCKEditorImages');
    Route::resource('mails', 'MailController');

    // Qiwi Api
    Route::delete('qiwi/destroy', 'QiwiController@massDestroy')->name('qiwi.massDestroy');
    Route::resource('qiwi', 'QiwiController');
});



Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {

    // User Statistic
    // Route::delete('user-statistics/destroy', 'UserStatisticController@massDestroy')->name('user-statistics.massDestroy');
    // Route::resource('user-statistics', 'UserStatisticController');

    // Route::get('/home', 'HomeController@index')->name('home');

    // // Permissions
    // Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    // Route::resource('permissions', 'PermissionsController');

    // // Roles
    // Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    // Route::resource('roles', 'RolesController');

    // // Users
    // Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    // Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    // Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    // Route::resource('users', 'UsersController');

    // // Currency
    // Route::delete('currencies/destroy', 'CurrencyController@massDestroy')->name('currencies.massDestroy');
    // Route::resource('currencies', 'CurrencyController');

    // // Balance
    // Route::delete('balances/destroy', 'BalanceController@massDestroy')->name('balances.massDestroy');
    // Route::resource('balances', 'BalanceController');

    // // Hardware Type
    // Route::delete('hardware-types/destroy', 'HardwareTypeController@massDestroy')->name('hardware-types.massDestroy');
    // Route::resource('hardware-types', 'HardwareTypeController');

    // // Hardware Item
    // Route::delete('hardware-items/destroy', 'HardwareItemController@massDestroy')->name('hardware-items.massDestroy');
    // Route::post('hardware-items/media', 'HardwareItemController@storeMedia')->name('hardware-items.storeMedia');
    // Route::post('hardware-items/ckmedia', 'HardwareItemController@storeCKEditorImages')->name('hardware-items.storeCKEditorImages');
    // Route::resource('hardware-items', 'HardwareItemController');

    // // Contract
    // Route::delete('contracts/destroy', 'ContractController@massDestroy')->name('contracts.massDestroy');
    // Route::resource('contracts', 'ContractController');

    // // Transaction
    // Route::delete('transactions/destroy', 'TransactionController@massDestroy')->name('transactions.massDestroy');
    // Route::resource('transactions', 'TransactionController');

    // // Contract Period
    // Route::delete('contract-periods/destroy', 'ContractPeriodController@massDestroy')->name('contract-periods.massDestroy');
    // Route::resource('contract-periods', 'ContractPeriodController');


    // // Message
    // Route::delete('messages/destroy', 'MessageController@massDestroy')->name('messages.massDestroy');
    // Route::resource('messages', 'MessageController');

    // // Faq
    // Route::delete('faqs/destroy', 'FaqController@massDestroy')->name('faqs.massDestroy');
    // Route::resource('faqs', 'FaqController');

    // // Setting
    // Route::delete('settings/destroy', 'SettingController@massDestroy')->name('settings.massDestroy');
    // Route::resource('settings', 'SettingController');

    // // Contact
    // Route::delete('contacts/destroy', 'ContactController@massDestroy')->name('contacts.massDestroy');
    // Route::resource('contacts', 'ContactController');

    // // Chat
    // Route::delete('chats/destroy', 'ChatController@massDestroy')->name('chats.massDestroy');
    // Route::resource('chats', 'ChatController');

    // // Withdrawl
    // Route::delete('withdrawls/destroy', 'WithdrawlController@massDestroy')->name('withdrawls.massDestroy');
    // Route::resource('withdrawls', 'WithdrawlController');

    // // Landing Page
    // Route::delete('landing-pages/destroy', 'LandingPageController@massDestroy')->name('landing-pages.massDestroy');
    // Route::resource('landing-pages', 'LandingPageController');

    // // Wallet
    // Route::delete('wallets/destroy', 'WalletController@massDestroy')->name('wallets.massDestroy');
    // Route::resource('wallets', 'WalletController');

    // // Cart
    // Route::delete('carts/destroy', 'CartController@massDestroy')->name('carts.massDestroy');
    // Route::resource('carts', 'CartController');

    // Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    // Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    // Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    // Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});

Route::get('/{url}', 'ContentPageController@index');
