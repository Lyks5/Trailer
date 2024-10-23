<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;
class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Пользователи и постеры
        $userIds = [12, 13, 14, 15];
        $posterIds = range(1, 11); // Постеры с ID от 1 до 11

        // Создаем случайные рейтинги
        foreach ($posterIds as $posterId) {
            foreach ($userIds as $userId) {
                Rating::create([
                    'user_id' => $userId,
                    'poster_id' => $posterId,
                    'rank' => rand(1, 10), // Случайный рейтинг от 1 до 10
                    'rating' => rand(1, 10),
                ]);
            }
        }
    }

}
