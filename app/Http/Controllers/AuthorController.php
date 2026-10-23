<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        // Mengambil data array Author dari Model
        $authors = Author::all();

        return view('authors.index', compact('authors'));
    }
}