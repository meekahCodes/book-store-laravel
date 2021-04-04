<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PassportController;

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

Route::group(['middleware' => 'json.response'], function () {


    Route::post('login',  [PassportController::class, 'login']);
    Route::post('register',  [PassportController::class, 'register']);

    Route::get('books', [BookController::class, 'showAllBooks']);
    Route::get('authors',  [UserController::class, 'getAllAuthors']);
    
    Route::group(['middleware' =>  'auth:api', 'prefix' => 'v1'], function () {
        Route::get('user', [PassportController::class, 'details']);
        Route::post('books', [BookController::class, 'store']);
        Route::post('user/change-status/{id}', [UserController::class, 'changeStatus']);
    });

});




