<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Menampilkan daftar semua buku beserta relasi data author dan genre dalam format JSON.
     */
    public function index(): JsonResponse
    {
        $books = Book::with(['author', 'genre'])->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data buku beserta author dan genre berhasil diambil',
            'data'    => $books,
        ], 200);
    }

    /**
     * Menyimpan data buku baru
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'genre_id'    => 'required|exists:genres,id',
            'author_id'   => 'required|exists:authors,id',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Jika upload file gambar
        if ($request->hasFile('cover_photo')) {
            $path = $request->file('cover_photo')->store('books', 'public');
            $validated['cover_photo'] = $path;
        }

        $book = Book::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Buku berhasil ditambahkan',
            'data'    => $book,
        ], 201);
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

    /**
     * Mengupdate data buku.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Buku tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric',
            'stock'       => 'sometimes|required|integer',
            'genre_id'    => 'sometimes|required|exists:genres,id',
            'author_id'   => 'sometimes|required|exists:authors,id',
            'cover_photo' => 'nullable',
        ]);

        if ($request->hasFile('cover_photo')) {
            // Hapus cover lama jika ada di storage
            if ($book->cover_photo && Storage::disk('public')->exists($book->cover_photo)) {
                Storage::disk('public')->delete($book->cover_photo);
            }
            $validated['cover_photo'] = $request->file('cover_photo')->store('books', 'public');
        }

        $book->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Buku berhasil diperbarui',
            'data'    => $book,
        ], 200);
    }

    /**
     * Menghapus buku.
     */
    public function destroy($id): JsonResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Buku tidak ditemukan',
            ], 404);
        }

        // Hapus file gambar jika ada
        if ($book->cover_photo && Storage::disk('public')->exists($book->cover_photo)) {
            Storage::disk('public')->delete($book->cover_photo);
        }

        $book->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Buku berhasil dihapus',
        ], 200);
    }
}