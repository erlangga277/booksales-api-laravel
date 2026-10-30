<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

// Read All (index) & Show Detail (show) untuk Genres dan Authors
Route::apiResource('genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);

// Read Books
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Create (store), Update (update), Destroy (destroy)
    Route::apiResource('genres', GenreController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('authors', AuthorController::class)->only(['store', 'update', 'destroy']);
});