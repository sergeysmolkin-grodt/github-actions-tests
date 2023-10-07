<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teacher_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('image', 255);
            $table->string('name', 255);
            $table->string('location', 255);
            $table->text('review');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_reviews');
    }
};
