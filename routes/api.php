<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

Route::get('/genres', [GenreController::class, 'index'])->name('api.genres.index');
Route::get('/authors', [AuthorController::class, 'index'])->name('api.authors.index');
Route::get('/books', [BookController::class, 'index'])->name('api.books.index');