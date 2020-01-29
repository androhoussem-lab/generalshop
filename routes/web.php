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

Route::get('/', function () {
    return view('welcome');
});
/* from laravel documentations
Route::middleware(['first', 'second'])->group(function () {
    Route::get('/', function () {
        // Uses first & second Middleware
    });

    Route::get('user/profile', function () {
        // Uses first & second Middleware
    });
});

*/
Route::middleware(['auth','user_is_admin'])->group(function(){
    //units
    Route::get('units' , 'UnitController@index')->name('units');
    Route::post('units' , 'UnitController@store');
    Route::delete('units' , 'UnitController@delete');
    Route::put('units' , 'UnitController@update');
    Route::get('search-units' , 'UnitController@search')->name('search-units');
    //categories
    Route::get('categories' , 'CategoryController@index')->name('categories');
    Route::post('categories' , 'CategoryController@store');
    Route::delete('categories','CategoryController@delete');
    Route::put('categories' , 'CategoryController@update');
    Route::get('search-categories' , 'CategoryController@search')->name('search-categories');
    Route::get('search-categories','CategoryController@search')->name('search-categories');


    //products
    Route::get('products' , 'ProductController@index')->name('products');
    Route::get('new-product','ProductController@newProduct')->name('new-product');
    Route::post('new-product' , 'ProductController@store');
    Route::get('update-product/{id}','ProductController@newProduct')->name('update-product');
    Route::put('update-product' , 'ProductController@update')->name('update-product');

    Route::delete('products/{id}' , 'ProductController@delete');

    //tags
    Route::get('tags','TagController@index')->name('tags');
    Route::post('tags','TagController@store');
    Route::delete('tags' ,'TagController@delete');
    Route::put('tags','TagController@update');
    Route::get('search-tags' ,'TagController@search')->name('search-tags');

    //payments
    //orders
    //shipment

    //countries
    Route::get('countries' , 'CountryController@index')->name('countries');
    Route::post('countries' , 'CountryController@store');
    Route::delete('countries' , 'CountryController@delete');
    Route::get('search-countries' , 'CountryController@search')->name('search-countries');
    //cities
    Route::get('cities' , 'CityController@index')->name('cities');
    //states
    Route::get('states' , 'StateController@index')->name('states');

    //reviews
    Route::get('reviews' , 'ReviewController@index')->name('reviews');
    Route::post('reviews' , 'ReviewController@store');
    Route::delete('reviews' , 'ReviewController@delete');
    Route::get('search-reviews' , 'ReviewController@search')->name('search-reviews');
    //tickets
    Route::get('tickets' , 'TicketController@index')->name('tickets');

    //roles
    Route::get('roles' , 'RoleController@index')->name('roles');
    Route::post('roles' , 'RoleController@store');
    Route::delete('roles' , 'RoleController@delete');
    Route::put('roles' , 'RoleController@update');
    Route::get('search-roles' , 'RoleController@search')->name('search-roles');



});

/*
Route::group(['auth' , 'user_is_admin'], function(){
    Route::get('add-unit' , 'UnitController@showAdd')->name('new-unit');
});
/*
Route::get('test-email',function (){
    return 'hello';
})->middleware(['auth' , 'email_verified']);

Route::get('tag-test',function (){
    $product = \App\Product::find(1);
    return $product->tags;
});

Route::get('role-test',function(){
    $user = \App\User::find(502);
    return $user->roles;
});
Route::get('welcome',function (){
    return 'welcome page';
})->middleware(['auth' , 'user_is_supporter']);
Route::get('cities',function (){
    return \App\City::with(['state','country'])->paginate(5);
});

Route::get('/users' , function (){
    return \App\User::paginate(50);
});
Route::get('/products' , function (){
    return \App\Product::with(['images'])->paginate(100);
});
Route::get('/images' , function (){
    return \App\Image::with('product')->paginate(100);
});
Route::get('/reviews' , function (){
    return \App\Review::with(['product' , 'customer'])->paginate(100);
});
Route::get('units-test','DataImportController@importUnit');
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
