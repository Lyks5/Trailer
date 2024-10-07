<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GenrePoster;
class GenrePosterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $genres_poster = [
            ['genre_id' => '1', 'poster_id'=> '1'],
            ['genre_id' => '2', 'poster_id'=> '1'],
            ['genre_id' => '2', 'poster_id'=> '2'],
            ['genre_id' => '3', 'poster_id'=> '3'],
            ['genre_id' => '4', 'poster_id'=> '4'],
            ['genre_id' => '5', 'poster_id'=> '5'],
            ['genre_id' => '6', 'poster_id'=> '6'],
            ['genre_id' => '7', 'poster_id'=> '7'],
            ['genre_id' => '8', 'poster_id'=> '8'],
            ['genre_id' => '9', 'poster_id'=> '9'],
            ['genre_id' => '10', 'poster_id'=> '10'],
            ['genre_id' => '1', 'poster_id'=> '11'],
        ];

        foreach ($genres_poster as $genreposter) {
            GenrePoster::create($genreposter);
        }
    }
}
