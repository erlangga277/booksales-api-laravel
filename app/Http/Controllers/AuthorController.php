<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    /**
     * Menampilkan daftar semua author beserta relasi daftar bukunya dalam format JSON.
     */
    public function index(): JsonResponse
    {
        // Mengambil data author beserta relasi daftar bukunya 
        $authors = Author::with('books')->get();

        // Mengembalikan response dalam bentuk JSON
        return response()->json([
            'status'  => 'success',
            'message' => 'Data author beserta buku berhasil diambil',
            'data'    => $authors,
        ], 200);
    }
}