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
    //categories
    Route::get('categories' , 'CategoryController@index')->name('categories');
    //products
    Route::get('products' , 'ProductController@index')->name('products');
    //tags

    //payments
    //orders
    //shipment

    //countries
    //cities
    //states



    //reviews
    //tickets

    //roles


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
