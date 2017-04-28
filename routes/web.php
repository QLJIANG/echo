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
Route::post('/postmessage', 'PostController@handle');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/message', 'HomeController@message');
    Route::get('/message/{user}', 'MessageController@index');
    Route::post('/message', 'MessageController@store');
});
Auth::routes();