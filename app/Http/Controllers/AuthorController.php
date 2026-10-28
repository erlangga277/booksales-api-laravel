<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Menampilkan daftar semua author beserta relasi bukunya.
     */
    public function index(): JsonResponse
    {
        $authors = Author::with('books')->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data author beserta buku berhasil diambil',
            'data'    => $authors,
        ], 200);
    }

    /**
     * Create data
     */
    public function store(Request $request): JsonResponse
    {
        // Validasi input
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
        ]);

        // Simpan ke database
        $author = Author::create($validated);

        // Response status 201 (Created)
        return response()->json([
            'status'  => 'success',
            'message' => 'Data author berhasil ditambahkan',
            'data'    => $author,
        ], 201);
    }
}