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


// Route::post('/paymentIPN', [\Paytabscom\Laravel_paytabs\Controllers\PaytabsLaravelListenerApi::class, 'paymentIPN'])->name('payment_ipn');
// Route::get('/payment', [\Paytabscom\Laravel_paytabs\Controllers\PaytabsLaravelListenerApi::class, 'index'])->name('payment');

Route::post('/paymentIPN', [PaytabsController::class, 'paymentIPN']);

