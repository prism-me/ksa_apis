<?php





Route::get('/paytabs_payment', 'PaytabsController@index');
Route::post('/paytabs_response', 'PaytabsController@response')->name('Paytabs.result');
