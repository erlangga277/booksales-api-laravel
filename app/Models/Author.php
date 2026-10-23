<?php

namespace App\Models;

class Author
{
    public static function all()
    {
        return [
            [
                'id' => 1,
                'name' => 'Tere Liye',
                'photo' => 'https://ui-avatars.com/api/?name=Tere+Liye&background=0D8ABC&color=fff',
                'bio' => 'Penulis produktif asal Indonesia dengan puluhan novel fiksi best-seller.'
            ],
            [
                'id' => 2,
                'name' => 'Andrea Hirata',
                'photo' => 'https://ui-avatars.com/api/?name=Andrea+Hirata&background=22c55e&color=fff',
                'bio' => 'Penulis novel fenomenal Laskar Pelangi yang diangkat ke layar lebar.'
            ],
            [
                'id' => 3,
                'name' => 'Dee Lestari',
                'photo' => 'https://ui-avatars.com/api/?name=Dee+Lestari&background=ec4899&color=fff',
                'bio' => 'Novelis dan musisi populer pencipta serial Supernova serta Aroma Karsa.'
            ],
            [
                'id' => 4,
                'name' => 'Pramoedya Ananta Toer',
                'photo' => 'https://ui-avatars.com/api/?name=Pramoedya+Ananta+Toer&background=f59e0b&color=fff',
                'bio' => 'Sastrawan terkemuka Indonesia pengarang karya legendaris Tetralogi Buru.'
            ],
            [
                'id' => 5,
                'name' => 'Habiburrahman El Shirazy',
                'photo' => 'https://ui-avatars.com/api/?name=Habiburrahman+El+Shirazy&background=6366f1&color=fff',
                'bio' => 'Novelis Indonesia bertema religius islami, pencipta Ayat-Ayat Cinta.'
            ],
        ];
    }
}