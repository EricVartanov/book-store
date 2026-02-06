<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\BookRating;
use Illuminate\Database\Seeder;

class BookRatingSeeder extends Seeder
{
    public function run(): void
    {
        // последние 3 пользователя оценят, чтобы первыми залогиниться и проверить спокойно
        $users = User::orderBy('id', 'desc')->take(3)->get();

        if ($users->isEmpty()) {
            return;
        }

        Book::all()->each(function ($book) use ($users) {
            foreach ($users as $user) {
                BookRating::firstOrCreate([
                    'book_id' => $book->id,
                    'user_id' => $user->id,
                ], [
                    'rating' => rand(1, 5),
                ]);
            }
        });
    }
}
