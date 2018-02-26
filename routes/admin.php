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

//    图书管理

//    图书分类
    Route::resource('/book/category', 'BookCategoryController');
    Route::post('/book/category/ops', 'BookCategoryController@ops');

//    会员管理
    Route::resource('/member', 'MemberController');
    Route::post('/member/ops', 'MemberController@ops');


//    图片上传
    Route::post('/upload/pic', 'UploadController@uploadImage');
});