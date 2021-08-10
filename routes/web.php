<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PagesController@root')->name('root');

Auth::routes(['verify' => true]);

Route::get('/change/password/reset', 'UserController@showRequestForm')->name('change.password.request');

Route::post('/change/password/reset', 'UserController@passwordrest')->name('change.password.update');

Route::get('/profile/', 'UserController@showProfileForm')->name('profile.request');

Route::post('/profile/', 'UserController@profile')->name('profile.update');

Route::get('/image/', 'UserController@showImageForm')->name('image.request');

Route::post('/image/', 'UserController@image')->name('image.update');

Route::get('/photo/{id}', 'PagesController@show')->name('image.show');

