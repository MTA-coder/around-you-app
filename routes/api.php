<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {

  Route::get('/user/get',function (){
        return response()->json(['status' => 'OK', 'data' => Auth::user()], 220);
    });

    Route::get('auth/logout', [AuthController::class, 'logOut']);

    Route::put('/user/edit', [UserController::class, 'edit']);

    Route::prefix('item')->group(function () {
        Route::get('getAuth', [ProductController::class, 'getAuth']);
        Route::post('/create', [ProductController::class, 'create']);
        Route::put('/update/{product_id}', [ProductController::class, 'edit']);
        Route::delete('/delete/{product_id}', [ProductController::class, 'delete']);
        Route::post('/image/create', [ProductController::class, 'imageCreate']);
        Route::post('/view/create', [ProductController::class, 'createView']);
        Route::get('searchItemsAuth', [ProductController::class, 'searchItems']);
        Route::get('filter', [ProductController::class, 'filter']);

    });
  

    Route::get('user/favourite/get', [FavouriteController::class, 'get']);
    Route::post('user/favourite/create', [FavouriteController::class, 'create']);

});

Route::prefix('category')->group(function () {
    Route::get('/get', [CategoryController::class, 'get']);
    Route::post('/create', [CategoryController::class, 'create']);
    Route::put('/update/{category_id}', [CategoryController::class, 'edit']);
    Route::delete('/delete/{category_id}', [CategoryController::class, 'delete']);
});

Route::prefix('subcategory')->group(function () {
    Route::get('/get/{categoryId}', [SubCategoryController::class, 'get']);
    Route::post('/create', [SubCategoryController::class, 'create']);
    Route::put('/update/{subCategory_id}', [SubCategoryController::class, 'edit']);
    Route::delete('/delete/{subCategory_id}', [SubCategoryController::class, 'delete']);
});

Route::post('/image/upload', [FileController::class, 'upload']);


Route::prefix('item')->group(function () {
    Route::get('get', [ProductController::class, 'get']);
    Route::get('searchItemsNoAuth', [ProductController::class, 'searchItemsNoAuth']);
  Route::get('user_item/get/{user_id}', [ProductController::class, 'getItem']);

});
