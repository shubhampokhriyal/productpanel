<?php

use App\Http\Controllers\Api\ProductDataController;
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

Route::get('/get-products', [ProductDataController::class, "index"]);
Route::post('/product/store', [ProductDataController::class, "store"]);
Route::post('/product/{id}', [ProductDataController::class, "update"]);
Route::get('/product/{id}', [ProductDataController::class, "show"]);
Route::delete('/product/{id}', [ProductDataController::class, "destroy"]);
Route::post('/delete/bulk-products', [ProductDataController::class, "destroyBulk"]);
