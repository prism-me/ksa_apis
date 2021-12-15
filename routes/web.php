<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/excel',function(){

    return view('import');
});

Route::post('importProducts','ProductController@import')->name('importProducts');

    Route::get('/paytabs_payment', 'PaytabsController@index');
    Route::post('/paytabs_response', 'PaytabsController@response')->name('Paytabs.result');

