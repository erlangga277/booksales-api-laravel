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
     * Menyimpan data author baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
        ]);

        $author = Author::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data author berhasil ditambahkan',
            'data'    => $author,
        ], 201);
    }

    /**
     * Menampilkan detail satu author berdasarkan ID beserta bukunya.
     */
    public function show(string|int $id): JsonResponse
    {
        $author = Author::with('books')->find($id);

        // Validasi jika data tidak ditemukan
        if (!$author) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data author tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail data author berhasil diambil',
            'data'    => $author,
        ], 200);
    }

    /**
     * Memperbarui data author berdasarkan ID.
     */
    public function update(Request $request, string|int $id): JsonResponse
    {
        $author = Author::find($id);

        // Validasi jika data tidak ditemukan
        if (!$author) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data author tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
        ]);

        $author->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data author berhasil diperbarui',
            'data'    => $author,
        ], 200);
    }

    /**
     * Menghapus data author berdasarkan ID.
     */
    public function destroy(string|int $id): JsonResponse
    {
        $author = Author::find($id);

        // Validasi jika data tidak ditemukan
        if (!$author) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data author tidak ditemukan',
            ], 404);
        }

        $author->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data author berhasil dihapus',
        ], 200);
    }
}