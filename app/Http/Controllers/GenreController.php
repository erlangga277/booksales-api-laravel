<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Menampilkan daftar semua genre dalam format JSON.
     */
    public function index(): JsonResponse
    {
        $genres = Genre::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data genre berhasil diambil',
            'data'    => $genres,
        ], 200);
    }

    /**
     * Create data
     */
    public function store(Request $request): JsonResponse
    {
        // Validasi input
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        // Simpan ke database
        $genre = Genre::create($validated);

        // Response status 201 (Created)
        return response()->json([
            'status'  => 'success',
            'message' => 'Data genre berhasil ditambahkan',
            'data'    => $genre,
        ], 201);
    }
}