<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('genres', GenreController::class);
Route::apiResource('authors', AuthorController::class);
Route::apiResource('books', BookController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Customer: Kirim Pesan ke Admin (Wajib Login)
    Route::post('/contact', [MessageController::class, 'store']);

    Route::middleware('admin')->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

        // Kelola User untuk Admin
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::patch('/users/{id}/role', [UserController::class, 'updateRole']);

        // Pesan Masuk (Kontak Pengguna)
        Route::get('/messages', [MessageController::class, 'index']);
        Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
    });

    // Customer: Transaksi
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);
});
