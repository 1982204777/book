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


Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');
Route::group(['middleware' => 'checkLogin'], function() {
    Route::get('test', 'BaseController@__construct');
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
//    用户
    Route::get('/user/edit', 'UserController@edit');
    Route::post('/user/update', 'UserController@update');
    Route::get('/user/reset-password', 'UserController@viewResetPassword');
    Route::post('/user/reset-password', 'UserController@resetPassword');

//    账户管理
    Route::resource('/account', 'AccountController');
    Route::post('/account/ops', 'AccountController@ops');

//    品牌管理
    Route::get('/brand/set', 'BrandController@set');
    Route::post('/brand/set', 'BrandController@doSet');
    Route::get('/brand/info', 'BrandController@info');
    Route::get('/brand/images', 'BrandController@images');
    Route::post('/brand/image', 'BrandController@image');
    Route::post('/brand/image-ops', 'BrandController@imageOps');

//    图书分类
    Route::resource('/book/category', 'BookCategoryController');
    Route::post('/book/category/ops', 'BookCategoryController@ops');

//    图书图片管理
    Route::get('/book/images', 'BookController@images');

//    图书管理
    Route::resource('/book', 'BookController');
    Route::post('/book/ops', 'BookController@ops');

//    会员管理
    Route::get('/member/comment', 'MemberController@comment');
    Route::resource('/member', 'MemberController');
    Route::post('/member/ops', 'MemberController@ops');

//    财务管理
    Route::get('/finance/account', 'FinanceController@account');
    Route::resource('/finance', 'FinanceController');
    Route::post('/finance/express', 'FinanceController@express');

//    营销渠道
    Route::get('/qrcode/make', 'QrCodeController@makeQrCode');
    Route::resource('/qrcode', 'QrCodeController');
    Route::post('/qrcode/{id}/delete', 'QrCodeController@destroy');

//    统计管理
    Route::get('/stat', 'StatController@index');
    Route::get('/stat/member', 'StatController@member');
    Route::get('/stat/product', 'StatController@product');
    Route::get('/stat/share', 'StatController@share');

//    highcharts图表
    Route::get('/charts/dashboard', 'ChartsController@dashboard');
    Route::get('/charts/finance', 'ChartsController@finance');
    Route::get('/charts/share', 'ChartsController@share');

//    图片上传
    Route::post('/upload/pic', 'UploadController@uploadImage');
});