<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_reminders_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('has_email_10_minutes_zoom_data')->default(false);
            $table->boolean('has_whatsapp_30_minutes')->default(false);
            $table->boolean('has_whatsapp_5_minutes')->default(false);
            $table->boolean('has_whatsapp_3_hours')->default(false);
            $table->boolean('has_ivr_2_5_minutes')->default(false);


            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_reminders_options');
    }
};
