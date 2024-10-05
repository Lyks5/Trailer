<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenresTableSeeder extends Seeder
{
    public function run()
    {
        $genres = ['Боевик', 'Комедия', 'Драма', 'Криминал', 'Мюзикл', 'Приключения', 'Фантастика', 'Фэнтези', 'Триллер', 'Ужасы'];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}