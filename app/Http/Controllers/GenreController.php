<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
     * Menyimpan data genre baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        $genre = Genre::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data genre berhasil ditambahkan',
            'data'    => $genre,
        ], 201);
    }

    /**
     * Menampilkan detail satu genre berdasarkan ID.
     */
    public function show(string|int $id): JsonResponse
    {
        $genre = Genre::find($id);

        // Validasi jika data tidak ditemukan
        if (!$genre) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data genre tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail data genre berhasil diambil',
            'data'    => $genre,
        ], 200);
    }

    /**
     * Memperbarui data genre berdasarkan ID.
     */
    public function update(Request $request, string|int $id): JsonResponse
    {
        $genre = Genre::find($id);

        // Validasi jika data tidak ditemukan
        if (!$genre) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data genre tidak ditemukan',
            ], 404);
        }

        // Validasi input (abaikan unique untuk ID genre yang sedang diupdate)
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', Rule::unique('genres', 'name')->ignore($genre->id)],
            'description' => ['nullable', 'string'],
        ]);

        $genre->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data genre berhasil diperbarui',
            'data'    => $genre,
        ], 200);
    }

    /**
     * Menghapus data genre berdasarkan ID.
     */
    public function destroy(string|int $id): JsonResponse
    {
        $genre = Genre::find($id);

        // Validasi jika data tidak ditemukan
        if (!$genre) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data genre tidak ditemukan',
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data genre berhasil dihapus',
        ], 200);
    }
}