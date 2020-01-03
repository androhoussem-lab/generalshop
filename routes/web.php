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
Route::get('test-email',function (){
    return 'hello';
})->middleware(['auth' , 'email_verified']);








/*
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
