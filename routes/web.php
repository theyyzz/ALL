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

Route::get('/redis', 'Redis\RedisController@index')->name('redis');

Route::group(['namespace' => 'All'], function(){
    Route::get('/', 'AllController@index')->name('index');
    Route::get('/chat', 'AllController@chat')->name('chat');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
