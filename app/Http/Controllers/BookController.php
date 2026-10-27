<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * Menampilkan daftar semua buku beserta relasi data author dalam format JSON.
     */
    public function index(): JsonResponse
    {
        // Mengambil data buku beserta relasi author
        $books = Book::with('author')->get();

        // Mengembalikan response dalam bentuk JSON
        return response()->json([
            'status'  => 'success',
            'message' => 'Data buku beserta author berhasil diambil',
            'data'    => $books,
        ], 200);
    }
}