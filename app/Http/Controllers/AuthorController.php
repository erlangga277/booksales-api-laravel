<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        // Mengambil semua data Author dari database 
        $authors = Author::with('books')->get();

        return view('authors.index', compact('authors'));
    }
}