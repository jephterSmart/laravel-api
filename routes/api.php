<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;
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
//This is the normal way to block a particular route
Route::middleware('auth:sanctum')->get('/user', function () {
    return "User was reached";
});
//If you want to block a group of route
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::get('/great',[ProductsController::class, 'index']);
    Route::post('/auth/logout',[AuthController::class,'logout']);
});
//The rest are all public routes;
Route::get('/products',[ProductsController::class, 'index']);
Route::post('/products',[ProductsController::class, 'store']);

Route::post('/auth/register',[AuthController::class,'register']);
Route::post('/auth/login',[AuthController::class,'login']);

