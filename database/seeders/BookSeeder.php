<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = User::pluck('id');

        if ($authors->isEmpty()) {
            throw new \RuntimeException('Нет пользователей для author_id');
        }

        $genres = Genre::pluck('id');

        Book::factory(4)->make()->each(function (Book $book) use ($authors, $genres) {
            $book->author_id = $authors->random();
            $book->save();

            $book->genres()->sync(
                $genres->random(rand(1, min(3, $genres->count())))
            );
        });
    }
}
