<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\GenreSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            UserSeeder::class,
            BookSeeder::class,
        ]);
    }
}
