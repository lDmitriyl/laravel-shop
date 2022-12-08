<?php

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'reset' => false
]);

Route::get('locale/{locale}', 'MainController@changeLocale')->name('locale');
Route::get('currency/{currencyCode}', 'MainController@changeCurrency')->name('currency');
Route::get('/logout', 'Auth\LoginController@logout')->name('get-logout');

Route::middleware(['set_locale'])->group(function (){
    Route::get('reset', 'ResetController@reset')->name('reset');
    Route::middleware(['auth'])->group(function (){
        Route::group([
            'prefix' => 'person',
            'namespace' => 'Person',
            'as' => 'person.'
        ], function (){
            Route::get('/orders', 'OrderController@index')->name('orders.index');
            Route::get('/orders/{order}', 'OrderController@show')->name('order-show');
        });

        Route::group([
            'namespace' => 'Admin',
            'prefix' => 'admin'
        ], function (){
            Route::group(['middleware' => 'is_admin'], function (){
                Route::get('/orders', 'OrderController@index')->name('home');
                Route::get('/orders/{order}', 'OrderController@show')->name('order-show');
            });
            Route::resource('categories', 'CategoryController');
            Route::resource('products', 'ProductController');
            Route::resource('products/{product}/pros', 'ProController');
            Route::resource('properties', 'PropertyController');
            Route::resource('properties/{property}/property-options', 'PropertyOptionController');
            Route::resource('coupons', 'CouponController');
        });
    });

    Route::get('/', 'MainController@index')->name('index');
    Route::get('/categories', 'MainController@categories')->name('categories');
    Route::post('/subscription/{pro}', 'MainController@subscribe')->name('subscription');

    Route::group(['prefix' => 'basket'], function (){
        Route::post('/add/{pro}', 'BasketController@addBasket')->name('add-basket');

        Route::group(['middleware' => 'basket_not_empty'], function (){
            Route::get('/', 'BasketController@basket')->name('basket');
            Route::get('/place', 'BasketController@basketPlace')->name('basket-place');
            Route::post('/remove/{pro}', 'BasketController@removeBasket')->name('remove-basket');
            Route::post('/confirm', 'BasketController@basketConfirm')->name('basket-confirm');
            Route::post('coupon', 'BasketController@setCoupon')->name('set-coupon');
        });

    });

    Route::get('/{category}', 'MainController@showCategory')->name('category');
    Route::get('/{category}/{product}/{pro}', 'MainController@ProductOffer')->name('product-offer');

});
