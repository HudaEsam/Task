<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
        // Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');

});

Route::group(['middleware' => 'jwt.auth'], function () {
Route::controller(CategoryController::class)->group(function () {
    Route::post('store', 'store');
    Route::get('categories', 'all');
    Route::get('category/{id}', 'show');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'delete');
});
});

Route::group(['middleware' => 'jwt.auth'], function () {
Route::controller(ProductController::class)->group (function (){
    Route::get('products',"allProducts");
    Route::get('product/{id}',"show");
    Route::post('create',"create");
    Route::put('edit/{id}',"update");
    Route::delete('deleteProduct/{id}',"delete");
});
});
