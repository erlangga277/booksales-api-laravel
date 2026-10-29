<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

// Resource Routes untuk Genre & Author (mencakup index, store, show, update, destroy)
Route::apiResource('genres', GenreController::class);
Route::apiResource('authors', AuthorController::class);

// Book Routes
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');