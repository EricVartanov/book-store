<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GenreFactory extends Factory
{
    private static array $genres = [
        'romance' => 'Романтика',
        'mystic' => 'Мистика',
        'fantasy' => 'Фэнтези',
        'detective' => 'Детектив',
        'drama' => 'Драма',
        'triller' => 'Триллер',
    ];

//    Создаем жанры
    public function definition(): array
    {
        $slug = $this->faker->unique()->randomElement(array_keys(self::$genres));

        return [
            'slug' => $slug,
            'name' => self::$genres[$slug],
        ];
    }
}
