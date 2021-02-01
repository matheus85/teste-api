<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;

Route::post('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'signup']);

Route::middleware('auth:api')->group(function () {
    Route::delete('logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'movies'], function () {
        Route::get('/', [MovieController::class, 'index']);
        Route::get('/{id}', [MovieController::class, 'show']);
    });

    Route::group(['prefix' => 'ratings'], function () {
        Route::get('/', [RatingController::class, 'index']);
        Route::get('/{id}', [RatingController::class, 'show']);
        Route::post('/', [RatingController::class, 'store']);
    });
});
