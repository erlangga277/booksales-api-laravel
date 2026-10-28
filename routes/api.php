<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

// Genre Routes
Route::get('/genres', [GenreController::class, 'index'])->name('api.genres.index');
Route::post('/genres', [GenreController::class, 'store'])->name('api.genres.store');

// Author Routes
Route::get('/authors', [AuthorController::class, 'index'])->name('api.authors.index');
Route::post('/authors', [AuthorController::class, 'store'])->name('api.authors.store');

// Book Routes
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');