<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\Comment\CommentController;

// Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
});


Route::resource('categories', CategoryController::class)->only(['index', 'store', 'show', 'update', 'destroy'])->middleware('auth:sanctum');
Route::resource('tags', TagController::class)->only(['index', 'store', 'show', 'update', 'destroy'])->middleware('auth:sanctum');
Route::resource('comments', CommentController::class)->only(['index', 'store', 'show', 'update', 'destroy'])->middleware('auth:sanctum');
