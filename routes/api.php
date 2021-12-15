<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayementController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('insertContact','GeneralController@insertContact');
Route::get('fetchContact','GeneralController@fetchContact');
Route::get('search','GeneralController@search');
Route::resource('categories','CategoryController');
Route::resource('pages','PageController');
Route::resource('products','ProductController');
Route::get('filteredProduct/{category?}/{sub_category?}/{filter?}','ProductController@filteredProduct');
Route::resource('reviews','ReviewController');
Route::resource('uploads','UploadController');
Route::resource('todo', 'TodoController');
Route::post('multipleUploads','UploadController@multipleUpload');
Route::resource('widgets','WidgetController');
Route::get('all_widgets/{id}','WidgetController@all_widgets');
Route::get('/update_route','GeneralController@update_route');
Route::resource('articles','ArticleController');
Route::resource('article_category','ArticleCategoryController');
Route::get('single_article_category/{route}','ArticleCategoryController@single_article_category');
Route::put('single_article_category_update/{route}','ArticleCategoryController@single_article_category_update');
Route::resource('good_to_know','GoodToKnowController');
Route::resource('video','VideoController');
Route::resource('blogs','BlogController');

Route::post('category_sorting','CategoryController@category_sorting');
Route::post('product_sorting','CategoryController@product_sorting');


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
    Route::resource('/wishlist','WishlistController');
    Route::post('/reset', [AuthController::class, 'reset']); 

    Route::resource('/order',OrderController::class);
    Route::resource('/shipping',ShippingController::class);
    Route::post('make-payement/{id}',[PayementController::class,'store']);
    Route::get('get-payement/{id}',[PayementController::class,'show']);
});


Route::get('auth/all_users', [AuthController::class, 'all_users']);

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'ar'

// ], function ($router) {

//     Route::resource('pages','AR\PageController');

// });

Route::fallback(function () {
    echo  json_encode(['message'=>'Undefined Route']);
});


// Payement Gateway




