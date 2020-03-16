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
        // category route
        Route::post('/category', 'CategoryController@create')->name('category_create');
        Route::delete('/category/{id}', 'CategoryController@delete')->name('category_delete');
        Route::get('/category', 'CategoryController@list')->name('category_list');
        Route::put('/category/{id}', 'CategoryController@update')->name('category_update');
        Route::get('/category/{id}', 'CategoryController@view')->name('category_view');

        // product route
        Route::post('/product', 'ProductController@create')->name('product_create');
        Route::delete('/product/{id}', 'ProductController@delete')->name('product_delete');
        Route::get('/product', 'ProductController@list')->name('product_list');
        Route::put('/product/{id}', 'ProductController@update')->name('product_update');
        Route::get('/product/{id}', 'ProductController@view')->name('product_view');

    });
});



