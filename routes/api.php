<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayementController;
use App\Http\Controllers\PaytabsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SearchController;
//use App\Http\Controllers\AddressController;
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

#Search
Route::get('navbar_search' , [SearchController::class , 'navbar_search']);
Route::get('navbar_search_ar' , [SearchController::class , 'navbar_search_arabic']);
    

Route::post('insertContact','GeneralController@insertContact');
Route::get('fetchContact','GeneralController@fetchContact');
Route::get('search','GeneralController@search');
Route::resource('categories','CategoryController');
Route::resource('pages','PageController');
Route::resource('products','ProductController');
#product list order
Route::post('product-indexing', 'ProductController@productIndexing');
Route::get('filteredProduct/{category?}/{sub_category?}/{filter?}','ProductController@filteredProduct');
Route::resource('reviews','ReviewController');
// Route::resource('uploads','UploadController');
Route::resource('todo', 'TodoController');
// Route::post('multipleUploads','UploadController@multipleUpload');
Route::resource('widgets','WidgetController');
Route::get('all_widgets/{id}','WidgetController@all_widgets');
Route::get('/update_route','GeneralController@update_route');
Route::resource('articles','ArticleController');
Route::resource('article_category','ArticleCategoryController');
Route::get('single_article_category/{route}','ArticleCategoryController@single_article_category');
Route::put('single_article_category_update/{route}','ArticleCategoryController@single_article_category_update');
Route::post('article-indexing', 'ArticleController@articleIndexing');
Route::post('article-category-indexing', 'ArticleCategoryController@articleCategoryIndexing');


Route::resource('good_to_know','GoodToKnowController');
Route::post('good-to-know-indexing', 'GoodToKnowController@goodToKnowIndexing');
Route::resource('video','VideoController');
Route::resource('blogs','BlogController');

Route::post('category_sorting','CategoryController@category_sorting');
Route::post('product_sorting','CategoryController@product_sorting');


#Upload
Route::post('multipleUploads','UploadController@multipleUpload');
//Route::resource('uploads','UploadController');
Route::get('uploads','UploadController@index');
Route::post('uploads','UploadController@store');
Route::get('uploads_images','UploadController@upload_images_dump');
  Route::delete('uploads','UploadController@destroy');



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
    Route::post('/reset', [AuthController::class, 'reset']); 
    Route::resource('wishlist','WishlistController');
    Route::get('delete_wishlist',[WishlistController::class ,'delete_wishlist']);
    

   
    // User Detail
    Route::post('reset', 'UserController@reset'); 
    Route::get('user-detail', 'UserController@userDetail'); 
    Route::post('update-detail', 'UserController@updateUser'); 

    // Card Detail
    Route::resource('/cards',CardController::class);
    Route::get('all-cards/{id}','CardController@getAll');

    Route::resource('/order',OrderController::class);
    Route::get('all-order','OrderController@allOrder');
    
    Route::resource('address',AddressController::class);
    // Route::get('delete-address',[AddressController::class ,'deleteAddress']);
    
    Route::resource('/shipping',ShippingController::class);
    Route::post('make-payement/{id}','PayementController@store');
    Route::get('get-payement/{id}','PayementController@show');
   


});


Route::get('test','GeneralController@test');


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


