<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * Menampilkan daftar semua buku beserta relasi data author dan genre dalam format JSON.
     */
    public function index(): JsonResponse
    {
        // Mengambil data buku beserta relasi author dan genre
        $books = Book::with(['author', 'genre'])->get();

        // Mengembalikan response dalam bentuk JSON
        return response()->json([
            'status'  => 'success',
            'message' => 'Data buku beserta author dan genre berhasil diambil',
            'data'    => $books,
        ], 200);
    }

    /**
     * Menampilkan detail satu buku.
     */
    public function show($id): JsonResponse
    {
        $book = Book::with(['author', 'genre'])->find($id);

        if (!$book) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Buku tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data detail buku berhasil diambil',
            'data'    => $book,
        ], 200);
    }
}
