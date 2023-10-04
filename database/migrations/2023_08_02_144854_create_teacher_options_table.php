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
        Schema::create('teacher_options', function (Blueprint $table) {
            $verificationStatuses = config('app.teacher_verification_statuses');

            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->text('bio')->nullable();
            $table->text('attainment')->nullable();
            $table->string('introduction_video')->nullable();
            $table->boolean('allows_trial')->default(false);
            $table->boolean('can_be_booked')->default(true);
            $table->boolean('is_teacher_for_business')->default(false);
            $table->boolean('is_teacher_for_children')->default(false);
            $table->boolean('is_teacher_for_beginner')->default(false);
            $table->enum('verification_status', $verificationStatuses)->default(reset($verificationStatuses));
            $table->string('zoom_user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_options');
    }
};
