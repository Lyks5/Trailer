<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->string('event_type'); // Тип события (просмотр страницы, клик и т.д.)
            $table->string('event_value')->nullable(); // Значение события (например, URL страницы)
            $table->unsignedBigInteger('user_id')->nullable(); // ID пользователя (если авторизован)
            $table->string('user_agent')->nullable(); // User-Agent браузера
            $table->string('ip_address')->nullable(); // IP-адрес пользователя
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('analytics');
    }
}