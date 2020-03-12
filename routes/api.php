<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api'])->group(function () {
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/register', 'RegisterController@register')->name('register');


    // Protected route requires valid token
    Route::middleware(['protected.route'])->group(function () {
        Route::post('/category', 'CategoryController@create')->name('category_create');
        Route::delete('/category/{id}', 'CategoryController@delete')->name('category_delete');
        Route::get('/category', 'CategoryController@list')->name('category_list');
        Route::put('/category/{id}', 'CategoryController@update')->name('category_update');
        Route::get('/category/{id}', 'CategoryController@view')->name('category_view');

        Route::get('/product', 'ProductController@list')->name('product_list');
    });
});



