<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        $authors = Author::with('books')->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data author beserta buku berhasil diambil',
            'data'    => $authors,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable',
            'bio'   => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('authors', 'public');
        }

        $author = Author::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data author berhasil ditambahkan',
            'data'    => $author,
        ], 201);
    }

    public function show(string|int $id): JsonResponse
    {
        $author = Author::with('books')->find($id);

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

    public function update(Request $request, string|int $id): JsonResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data author tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable',
            'bio'   => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            if ($author->photo && Storage::disk('public')->exists($author->photo)) {
                Storage::disk('public')->delete($author->photo);
            }
            $validated['photo'] = $request->file('photo')->store('authors', 'public');
        }

        $author->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data author berhasil diperbarui',
            'data'    => $author,
        ], 200);
    }

    public function destroy(string|int $id): JsonResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data author tidak ditemukan',
            ], 404);
        }

        if ($author->photo && Storage::disk('public')->exists($author->photo)) {
            Storage::disk('public')->delete($author->photo);
        }

        $author->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data author berhasil dihapus',
        ], 200);
    }
}
