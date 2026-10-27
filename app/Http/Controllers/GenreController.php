<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;

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
}