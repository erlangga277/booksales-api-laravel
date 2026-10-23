<?php

namespace App\Models;

class Genre
{
    public static function all()
    {
        return [
            [
                'id' => 1,
                'name' => 'Fiction',
                'description' => 'Karya sastra berisi cerita rekaan atau imajinasi penulis.'
            ],
            [
                'id' => 2,
                'name' => 'Non-Fiction',
                'description' => 'Buku yang memuat informasi nyata, fakta, dan data faktual.'
            ],
            [
                'id' => 3,
                'name' => 'Science Fiction',
                'description' => 'Cerita fiksi ilmiah berbasis perkembangan ilmu pengetahuan dan teknologi masa depan.'
            ],
            [
                'id' => 4,
                'name' => 'Fantasy',
                'description' => 'Kisah imajinatif dengan unsur magis, sihir, dan dunia supernatural.'
            ],
            [
                'id' => 5,
                'name' => 'Mystery',
                'description' => 'Cerita investigasi pemecahan kasus kejahatan atau teka-teki misterius.'
            ],
        ];
    }
}