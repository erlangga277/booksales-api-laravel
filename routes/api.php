<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Read All & Show Detail Author dan Genre
Route::apiResource('genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');

Route::middleware('auth:sanctum')->group(function () {
    // Logout untuk user yang sedang login
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin Only: Create, Update, Destroy Genre & Author
    Route::middleware('admin')->group(function () {
        Route::apiResource('genres', GenreController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('authors', AuthorController::class)->only(['store', 'update', 'destroy']);
    });
});