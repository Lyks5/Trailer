<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('post_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('poster_id');
            $table->integer('rank')->unsigned(); // Изменено на rank
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('poster_id')->references('id')->on('posters')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_ratings');
    }
}