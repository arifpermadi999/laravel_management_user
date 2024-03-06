<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;


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

Route::post('/login', [AuthController::class, 'login']);
Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['jwt.verify']], function() {
	Route::get('/users/total', [UserController::class,'totalCount']);
	Route::get('/users', [UserController::class,'index']);
	Route::post('/users/save', [UserController::class,'store']);
	Route::post('/users/update', [UserController::class,'update']);
	Route::get('/users/delete/{id}', [UserController::class,'destroy']);
	Route::get('/users/show/{id}', [UserController::class,'show']);
	Route::get('/logout', [AuthController::class, 'logout']);
});



