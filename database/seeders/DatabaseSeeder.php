<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Customer
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@mail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        
        $author = Author::create(['name' => 'Tere Liye']);
        $genre = Genre::create(['name' => 'Novel']);

        Book::create([
            'title' => 'Bumi',
            'description' => 'Petualangan fantasi',
            'price' => 85000,
            'stock' => 10,
            'author_id' => $author->id,
            'genre_id' => $genre->id,
        ]);
    }
}