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
});