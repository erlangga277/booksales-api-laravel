<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Bumi',
                'description' => 'Awal petualangan tiga remaja di dunia paralel klan Bulan.',
                'price' => 95000.00,
                'stock' => 30,
                'cover_photo' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=300&q=80',
                'genre_id' => 1,  
                'author_id' => 1,
            ],
            [
                'title' => 'Laskar Pelangi',
                'description' => 'Kisah perjuangan sepuluh anak di Belitung dalam meraih pendidikan dan mimpi.',
                'price' => 88000.00,
                'stock' => 25,
                'cover_photo' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=300&q=80',
                'genre_id' => 1,
                'author_id' => 2,
            ],
            [
                'title' => 'Aroma Karsa',
                'description' => 'Eksplorasi misteri tanaman legendaris Puspa Karsa berbalut mitologi dan aroma mistis.',
                'price' => 110000.00,
                'stock' => 15,
                'cover_photo' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=300&q=80',
                'genre_id' => 4,
                'author_id' => 3,
            ],
            [
                'title' => 'Bumi Manusia',
                'description' => 'Karya sastra klasik tentang pergulatan batin Minke di era kolonial Hindia Belanda.',
                'price' => 125000.00,
                'stock' => 20,
                'cover_photo' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=300&q=80',
                'genre_id' => 1,
                'author_id' => 4,
            ],
            [
                'title' => 'Ayat-Ayat Cinta',
                'description' => 'Kisah cinta islami dan perjuangan mahasiswa Indonesia yang menimba ilmu di Universitas Al-Azhar, Kairo.',
                'price' => 85000.00,
                'stock' => 18,
                'cover_photo' => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=300&q=80',
                'genre_id' => 1,
                'author_id' => 5,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}