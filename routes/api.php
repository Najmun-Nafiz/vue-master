<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::group(['prefix' => 'auth'], function () {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
    });

});



Route::resource('categories', 'Backend\CategoryController');
Route::resource('products', 'Backend\ProdctController');
Route::get('allcategory', 'Backend\ProdctController@allCategory');