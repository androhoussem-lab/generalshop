<?php

use Illuminate\Http\Request;

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
//get categories
Route::get('categories' , 'Api\CategoryController@index');
Route::get('categories/{id}' , 'Api\CategoryController@show');
//get tags
Route::get('tags' , 'Api\TagController@index');
Route::get('tags/{id}' , 'Api\TagController@show');
//get products
Route::get('products' , 'Api\ProductController@index');
Route::get('products/{id}' , 'Api\ProductController@show');

//general routes
Route::get('countries' , 'Api\CountryController@index');
Route::get('countries/{id}' , 'Api\CountryController@show');
Route::get('countries/{id}/states' , 'Api\CountryController@showStates');
Route::get('countries/{id}/cities' , 'Api\CountryController@showCities');
Route::group(['auth:api'],function (){
     // get
});

