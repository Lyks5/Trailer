<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Получаем всех пользователей
        $users = User::all();

        // Обновляем каждого пользователя
        foreach ($users as $user) {
            $randomDate = Carbon::now()->subDays(rand(0, 30)); // Случайная дата в пределах последних 30 дней
            $user->update([
                'last_login_at' => $randomDate,
            ]);
        }
    }
}
