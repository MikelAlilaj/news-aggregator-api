<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PersonalizedNewsController;
use App\Http\Controllers\Api\SourceController;
use App\Http\Controllers\Api\UserPreferenceController;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::patch('/user-preference', [UserPreferenceController::class, 'update']);
    Route::get('/user-preference', [UserPreferenceController::class, 'index']);
    Route::get('/personalized-news', [PersonalizedNewsController::class, 'index']);
    Route::get('/news', [NewsController::class, 'index']);

    Route::get('authors', [AuthorController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('sources', [SourceController::class, 'index']);
});



