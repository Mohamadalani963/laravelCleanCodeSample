<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('category')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::delete('/{id}', 'delete');
    Route::put('/{id}', 'update');
    Route::post('/', 'store');
});
Route::prefix('product')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::delete('/{id}', 'delete');
    Route::put('/{id}', 'update');
    Route::post('/', 'store');
});
Route::prefix('productImage')->controller(ProductImageController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::delete('/{id}', 'delete');
    Route::put('/{id}', 'update');
    Route::post('/', 'store');
});
