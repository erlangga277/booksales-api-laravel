<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            [
                'id' => 1,
                'name' => 'Fiction',
                'description' => 'Karya sastra imajinatif berupa novel, cerita pendek, dan roman.'
            ],
            [
                'id' => 2,
                'name' => 'Non-Fiction',
                'description' => 'Buku berdasarkan fakta, sejarah, biografi, dan pengetahuan nyata.'
            ],
            [
                'id' => 3,
                'name' => 'Science & Technology',
                'description' => 'Buku bertema sains, komputer, teknologi, dan eksplorasi ilmu pengetahuan.'
            ],
            [
                'id' => 4,
                'name' => 'Fantasy & Mystery',
                'description' => 'Kisah fantasi magis, petualangan dunia lain, dan teka-teki misteri.'
            ],
            [
                'id' => 5,
                'name' => 'Self Improvement',
                'description' => 'Buku panduan pengembangan diri, motivasi, dan produktivitas hidup.'
            ],
        ];

        foreach ($genres as $genre) {
            Genre::updateOrCreate(['id' => $genre['id']], $genre);
        }
    }
}
