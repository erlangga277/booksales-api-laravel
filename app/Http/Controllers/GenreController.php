<?php

namespace App\Http\Controllers;

use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        // Mengambil data array Genre dari Model
        $genres = Genre::all();

        return view('genres.index', compact('genres'));
    }
}