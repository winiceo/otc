<?php

use Illuminate\Support\Facades\Route;


\Illuminate\Support\Facades\Auth::routes();

Route::middleware('auth')->group(function () {
    Route::prefix('settings')->group(function () {
        Route::get('account', 'UsersController@edit')->name('users.edit');
        Route::get('show', 'UsersController@edit')->name('users.show');
        Route::match(['put', 'patch'], 'account', 'UsersController@update')->name('users.update');

        Route::get('password', 'UserPasswordsController@edit')->name('users.password');
        Route::match(['put', 'patch'], 'password', 'UserPasswordsController@update')->name('users.password.update');

        Route::get('token', 'UserTokensController@edit')->name('users.token');
        Route::match(['put', 'patch'], 'token', 'UserTokensController@update')->name('users.token.update');
    });

    Route::resource('newsletter-subscriptions', 'NewsletterSubscriptionsController', ['only' => 'store']);
});

Route::as('site.')->namespace('Genv\Web\Web\Controllers')->group(function () {
    Route::get('/', HomeController::class.'@index')->name('home');
   // Route::get('/buy', 'TradeController@buy')->name('buy');
//    Route::get('/sell', 'TradeController@sell')->name('sell');
//    Route::get('/advert', 'TradeController@sell')->name('advert');
        Route::get('/login3', 'AccountController@index')->name('login');
        Route::get('/logout', 'AccountController@index')->name('logout');
        Route::get('/register', 'AccountController@index')->name('register');
        Route::get('/adf', 'AccountController@index')->name('users.show');
        Route::get('/adfs', 'AccountController@index')->name('users.edit');

     Route::group(['prefix' => 'advert'], function () {
         Route::get('create', 'AdvertsController@create')->name('advert.create');
         Route::get('store', 'AdvertController@store');
         Route::get('detail/{id}', 'AdvertController@detail')->name('advert.detail');

         Route::get('edit/{id}', 'AdvertController@edit')->name('advert.edit');
         Route::get('delete/{id}', 'AdvertController@delete')->name('advert.delete');
     });

    // // Category
     Route::group(['prefix' => 'trade'], function () {
         Route::get('/', 'TradeController@overview')->name('trade.overview');
         Route::get('/buy/{coin}', 'TradeController@buy')->name('trade.buy')->where('id', '[0-9]+');
         Route::get('/sell/{coin}', 'TradeController@sell')->name('trade.sell')->where('id', '[0-9]+');
     });

     //order
     Route::group(['prefix' => 'order'], function () {
         Route::get('info/{id}', 'OrderController@info')->name('order.info');
     });

     Route::group(['prefix' => 'users'], function () {
         Route::get('/', 'AccountController@index');
         Route::get('/avatar/{id}', 'UserInfoController@avatar');

         Route::group(['middleware' => 'auth'], function () {
             Route::get('/', 'AccountController@index');
             Route::get('security', 'AccountController@security');
             Route::get('trusted', 'AccountController@trusted');
             Route::get('trusting', 'AccountController@trusting');

             Route::get('blocking', 'AccountController@blocking');

             Route::get('wallet', 'WalletController@index');
             Route::get('wallet/deposit/{id}', 'WalletController@depoist');
             Route::get('wallet/withdraw/{id}', 'WalletController@withdraw');

             Route::get('profile', 'AccountController@edit');
             Route::get('advert', 'AccountController@adverts')->name('users.adverts');

             Route::put('profile/{id}', 'AccountController@update');
             Route::post('follow/{id}', 'AccountController@doFollow');
             Route::get('notification', 'AccountController@notifications');
             Route::post('notification', 'AccountController@markAsRead');

             //更新用户资料
             Route::post('info', 'UserInfoController@update');

             //用户订单
             Route::get('orders', 'OrderController@overview')->name('users.orders');
         });

         Route::group(['prefix' => '{username}'], function () {
             // Route::get('/', 'AccountController@show');
             Route::get('comments', 'AccountController@comments');
             Route::get('following', 'AccountController@following');
             Route::get('discussions', 'AccountController@discussions');
         });
     });

     Route::resource('media', 'MediaController', ['only' => 'show']);
     Route::get('/posts.feed', 'PostsFeedController@index')->name('posts.feed');
     Route::resource('posts', 'PostsController', ['only' => 'show']);
     //Route::resource('users', 'UsersController', ['only' => 'show']);

    // Route::get('newsletter-subscriptions/unsubscribe', 'NewsletterSubscriptionsController@unsubscribe')->name('newsletter-subscriptions.unsubscribe');
});
