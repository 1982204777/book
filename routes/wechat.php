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


Route::get('/', 'WelcomeController@index');
Route::get('/home', 'WelcomeController@index');
Route::get('/menu/set', 'MenuController@setMenu');
Route::get('/oauth/login', 'OauthController@login');
Route::get('/oauth/callback', 'OauthController@callback');

Route::get('/bind', 'BindController@bind');
Route::get('/bind/img-captcha', 'BindController@getCaptcha');
Route::get('/bind/set-captcha', 'BindController@setImgCaptcha');