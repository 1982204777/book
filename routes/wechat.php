<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/menu/set', '\App\Http\Controllers\Wechat\wx\MenuController@setMenu');
Route::get('/oauth/login', 'OauthController@login');
Route::get('/oauth/callback', 'OauthController@callback');
Route::get('/oauth/logout', 'OauthController@logout');
Route::get('/sample', '\App\Http\Controllers\Wechat\wx\MsgController@index');

Route::get('/jssdk/sign', '\App\Http\Controllers\Wechat\wx\JssdkController@index');

Route::post('/product/order/pay/callback', 'ProductController@payCallback');

Route::get('/bind', 'BindController@index');
Route::post('/bind', 'BindController@bind');
Route::get('/bind/img-captcha', 'BindController@getCaptcha');
Route::get('/bind/set-captcha', 'BindController@setImgCaptcha');

Route::group(['middleware' => 'checkWechatLogin'], function() {
    Route::get('/', 'WelcomeController@index');
    Route::get('/home', 'WelcomeController@index');

    Route::get('/product', 'ProductController@index');
    Route::get('/product/search', 'ProductController@search');
    Route::get('/product/info', 'ProductController@show');
    Route::post('/product/fav', 'ProductController@fav');
    Route::post('/product/ops', 'ProductController@ops');
    Route::post('/product/cart', 'ProductController@addToCart');
    Route::post('/product/share', 'ProductController@share');
    Route::match(['get', 'post'],'/product/order', 'ProductController@order');
    Route::match(['get', 'post'],'/product/cartOrder', 'ProductController@cartOrder');
    Route::post('/product/placeOrder', 'ProductController@placeOrder');
    Route::get('/product/order/pay', 'ProductController@payView');

    Route::get('/user', 'UserController@index');
    Route::get('/user/cart', 'UserController@cart');
    Route::get('/user/order', 'UserController@order');
    Route::get('/user/fav', 'UserController@fav');
    Route::get('/user/comment', 'UserController@comment');
    Route::post('/user/orderOps', 'UserController@orderOps');

    Route::resource('/user/address', 'AddressController');
    Route::post('/user/address/getProvinceCityTree', 'AddressController@getProvinceCityTree');
    Route::post('/user/address/ops', 'AddressController@ops');

});
Route::get('clear', 'WelcomeController@cookieClear');
