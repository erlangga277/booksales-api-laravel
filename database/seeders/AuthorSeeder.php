<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Tere Liye',
                'photo' => 'https://ui-avatars.com/api/?name=Tere+Liye&background=0D8ABC&color=fff',
                'bio' => 'Penulis produktif asal Indonesia dengan puluhan novel fiksi best-seller.'
            ],
            [
                'name' => 'Andrea Hirata',
                'photo' => 'https://ui-avatars.com/api/?name=Andrea+Hirata&background=22c55e&color=fff',
                'bio' => 'Penulis novel fenomenal Laskar Pelangi yang diangkat ke layar lebar.'
            ],
            [
                'name' => 'Dee Lestari',
                'photo' => 'https://ui-avatars.com/api/?name=Dee+Lestari&background=ec4899&color=fff',
                'bio' => 'Novelis dan musisi populer pencipta serial Supernova serta Aroma Karsa.'
            ],
            [
                'name' => 'Pramoedya Ananta Toer',
                'photo' => 'https://ui-avatars.com/api/?name=Pramoedya+Ananta+Toer&background=f59e0b&color=fff',
                'bio' => 'Sastrawan terkemuka Indonesia pengarang karya legendaris Tetralogi Buru.'
            ],
            [
                'name' => 'Habiburrahman El Shirazy',
                'photo' => 'https://ui-avatars.com/api/?name=Habiburrahman+El+Shirazy&background=6366f1&color=fff',
                'bio' => 'Novelis Indonesia bertema religius islami, pencipta Ayat-Ayat Cinta.'
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}