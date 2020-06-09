<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register')->name('register');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'AuthController@logout')->name('logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('/items', 'ItemController@index')->name('items');
    Route::get('/items/{item}', 'ItemController@show')->name('item');
    Route::post('/items/store', 'ItemController@store')->name('item_store');
    Route::patch('/items/update/{item}', 'ItemController@update')->name('item_update');
    Route::delete('/items/destroy/{item}', 'ItemController@destroy')->name('item_destroy');
});
