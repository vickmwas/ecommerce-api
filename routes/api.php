<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group([ 'middleware' => 'api' ], function ($router) {
    Route::get('/products', [ProductController::class, 'getProducts']);
    Route::get('/products/my', [ProductController::class, 'getMerchantProducts']);
    Route::post('/products/add', [ProductController::class, 'addProduct']);
    Route::put('/products/{product_id}/edit', [ProductController::class, 'editProduct']);
});
Route::post('/products/image/upload', [ProductController::class, 'uploadImage']);
