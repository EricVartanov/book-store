<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use App\Models\BookRating;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookRatingFactory extends Factory
{
    protected $model = BookRating::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->value('id'),
            'user_id' => User::inRandomOrder()->value('id'),
            'rating'  => $this->faker->numberBetween(1, 5),
        ];
    }
}
