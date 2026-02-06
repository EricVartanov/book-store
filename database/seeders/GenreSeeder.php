<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['slug' => 'romance', 'name' => 'Романтика'],
            ['slug' => 'mystic', 'name' => 'Мистика'],
            ['slug' => 'fantasy', 'name' => 'Фэнтези'],
            ['slug' => 'drama', 'name' => 'Драма'],
            ['slug' => 'detective', 'name' => 'Детектив'],
        ];

        foreach ($genres as $genre) {
            Genre::query()->firstOrCreate(
                ['slug' => $genre['slug']],
                ['name' => $genre['name']]
            );
        }
    }
}
