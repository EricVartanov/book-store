<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    private static array $books = [
        [
            'title' => 'Метро 2033',
            'description' => 'Постапокалиптический роман о выживании людей в московском метро после ядерной войны.',
            'cover' => 'covers/metro2033.webp',
            'adult' => true,
            'rating' => 4.7,
        ],
        [
            'title' => 'Мастер и Маргарита',
            'description' => 'Мистический роман о добре и зле, любви и дьяволе в Москве 1930-х годов.',
            'cover' => 'covers/master_margarete.webp',
            'adult' => false,
            'rating' => 4.9,
        ],
        [
            'title' => 'American Psycho',
            'description' => 'Психологический триллер о двойной жизни успешного финансиста и серийного убийцы.',
            'cover' => 'covers/american_psyho.webp',
            'adult' => true,
            'rating' => 4.2,
        ],
        [
            'title' => 'Игра престолов',
            'description' => 'В мире Вестероса переплетаются политика, предательство, магия и судьбы множества героев.',
            'cover' => 'covers/game_of_thrones.webp',
            'adult' => true,
            'rating' => 4.7,
        ],
    ];

    public function definition(): array
    {
        static $index = 0;

        return self::$books[$index++ % count(self::$books)];
    }
}
